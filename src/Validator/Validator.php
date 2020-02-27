<?php

namespace JasperFW\Validator\Validator;

use JasperFW\Validator\Constraint\Constraint;
use JasperFW\Validator\Filter\Filter;
use JasperFW\Validator\InputSources;
use JasperFW\Validator\ValidationCheckerInterface;
use JasperFW\Validator\ValidationError;
use RuntimeException;

/**
 * Class Validator
 *
 * The base class that all validators extend.
 *
 * @package JasperFW\Validator\Validator
 */
abstract class Validator
{
    /** @var string The regex used by the class */
    protected static $regex = '/^.+$/i';
    /** @var string The name of the field */
    protected $fieldName;
    /** @var int The source of the data */
    protected $dataSource;
    /** @var Filter[] Filters to pre-process the provided value */
    protected $filters;
    /** @var Constraint[] Additional rules to check */
    protected $constraints;
    /** @var mixed The value being validated */
    protected $rawValue;
    /** @var string The validated value */
    protected $value;
    /** @var null|bool True if the value is valid */
    protected $isValid = null;
    /** @var string The error message for the validation, or null if no error was triggered */
    protected $theMessage = null;
    /** @var ValidationCheckerInterface Reference to the set of validator for the current form */
    protected $validationSet;
    /** @var string The error message to display if the validation fails */
    protected $errorMessage = 'The value of %s is not valid.';

    /**
     * Validates input as a one-off. Allows quick and dirty validation. Returns null if the value is not valid.
     *
     * TODO: Decide should this just return true/false if the value is/not valid?
     *
     * @param string $value       The value to test
     * @param array  $constraints The definition of the constraints
     *
     * @return mixed The value if valid
     */
    public static function quickValidate(
        ?string $value,
        array $filters = [],
        array $constraints = [],
        ?string &$errorMessage = ''
    ) {
        // Initialize the validator
        $validator = new static('quickValidate function', InputSources::PASSED, [], $value, null);
        // Add the filters
        if (is_array($filters) && count($filters) > 0) {
            foreach ($filters as $filter) {
                if (is_array($filter) && count($filter) > 0) {
                    $validator->addFilter(Filter::factory($filter));
                } elseif (!is_array($filter)) {
                    $validator->addFilter($filter);
                }
            }
        }
        // Add the constraints
        if (is_array($constraints) && count($constraints) > 0) {
            foreach ($constraints as $constraint) {
                /** @var Constraint|array $constraint */
                if (is_array($constraint) && count($constraint) > 0) {
                    $validator->addConstraint(Constraint::factory($constraint));
                } elseif (!is_array($constraint)) {
                    $validator->addConstraint($constraint);
                }
            }
        }
        // Return the value or throw an exception
        $validator->validate();
        if ($validator->isValid()) {
            return $validator->getValue();
        } else {
            $errorMessage = $validator->getError();
            return null;
        }
    }

    /**
     * @param string       $fieldName    The name of the field
     * @param int          $dataSource   The array the field value is stored in, or null if the value is being passed
     *                                   directly
     * @param Constraint[] $constraints  Additional rules to check against the passed value
     * @param null|string  $fieldValue   The value, if it is being directly passed.
     * @param null|string  $errorMessage An error message, or null to use the default
     */
    public function __construct(
        string $fieldName,
        int $dataSource = InputSources::EITHER,
        array $constraints = [],
        string $fieldValue = null,
        string $errorMessage = null
    ) {
        $this->fieldName = $fieldName;
        $this->dataSource = $dataSource;

        if (null !== $errorMessage) {
            $this->errorMessage = $errorMessage;
        }

        $this->constraints = [];
        // If just one constraint was passed convert to an array
        if (null === $constraints) {
            $constraints = [];
        }
        foreach ($constraints as $constraint) {
            $this->addConstraint($constraint);
        }

        // Set the raw value
        if (InputSources::PASSED == $dataSource) {
            $this->rawValue = $fieldValue;
        } elseif (isset($_POST[$fieldName]) &&
            (InputSources::EITHER == $dataSource || InputSources::POST == $dataSource)) {
            $this->rawValue = $_POST[$fieldName];
        } elseif (isset($_GET[$fieldName]) &&
            (InputSources::EITHER == $dataSource || InputSources::GET == $dataSource)) {
            $this->rawValue = $_GET[$fieldName];
        } else {
            $this->rawValue = null;
        }
    }

    /**
     * Add a filter to the validator
     *
     * @param array|Filter $filter The filter object or definition array to be added
     */
    public function addFilter($filter): void
    {
        /** @var Filter|array $filter */
        if (is_array($filter) && count($filter) > 0) {
            $filter = Filter::factory($filter);
        }
        if (!$filter instanceof Filter) {
            throw new RuntimeException('Unable to add constraint.');
        }
        $filter->setValidator($this);
        array_push($this->filters, $filter);
    }

    /**
     * Add a constraint to the validator
     *
     * @param array|Constraint $constraint A constraint object or the array defining a new constraint
     */
    public function addConstraint($constraint): void
    {
        /** @var Constraint|array $constraint */
        if (is_array($constraint) && count($constraint) > 0) {
            $constraint = Constraint::factory($constraint);
        }
        if (!$constraint instanceof Constraint) {
            throw new RuntimeException('Unable to add constraint.');
        }
        $constraint->setValidator($this);
        array_push($this->constraints, $constraint);
    }

    /**
     * @return ValidationCheckerInterface
     */
    public function getValidationSet(): ValidationCheckerInterface
    {
        return $this->validationSet;
    }

    /**
     * Set the validation set that this validator belongs to.
     *
     * @param ValidationCheckerInterface $validationSet
     */
    public function setValidationSet(ValidationCheckerInterface &$validationSet): void
    {
        $this->validationSet = $validationSet;
    }

    /**
     * Return the error message generated for this validation.
     *
     * @return null|string
     */
    public function getError(): ?string
    {
        return $this->theMessage;
    }

    /**
     * Report the error message to validation set
     *
     * @param string $errorMessage The error message to report
     */
    public function reportError(string $errorMessage): void
    {
        $errorMessage = sprintf($errorMessage, $this->fieldName);
        if (null != $this->validationSet) {
            $this->validationSet->addValidationError(new ValidationError($this->fieldName, $errorMessage));
        }
    }

    /**
     * Get the value if the value was validated.
     *
     * @return string
     */
    public function getValue(): string
    {
        if (null === $this->isValid) {
            $this->validate();
        }
        return $this->value;
    }

    /**
     * Return true if the value is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (null === $this->isValid) {
            $this->validate();
        }
        return $this->isValid;
    }

    /**
     * Return the raw value, sanitized for display in an error message or for other uses.
     *
     * @return string
     */
    public function getSanitizedRawValue(): string
    {
        return strip_tags($this->rawValue);
    }

    /**
     * Return the raw value with no sanitization. If this is going to be used in any sort of display to the end user,
     * use the getSanitizedRawValue() method.
     *
     * @return mixed
     */
    public function getRawValue()
    {
        return $this->rawValue;
    }

    /**
     * Do the validation. This process starts by filtering the value, then checks the validity, and finally checks
     * the constraints.
     */
    public function validate(): void
    {
        $this->value = null;
        $value = $this->filter($this->rawValue);
        if (true === $this->checkValidity($value)) {
            $this->isValid = true;
        } else {
            $this->isValid = false;
            $this->reportError($this->errorMessage);
            $error_message = sprintf($this->errorMessage, $this->fieldName);
            $this->theMessage = $error_message;
        }
        // If no issues have been found, check the constraints.
        if ($this->isValid) {
            foreach ($this->constraints as $constraint) {
                if (false === $constraint->check($value)) {
                    $this->isValid = false;
                    $this->theMessage = sprintf($constraint->getErrorMessage(), $this->fieldName);
                }
            }
        }
        // Set the value for retrieval
        if ($this->isValid) {
            $this->value = $value;
        }
    }

    /**
     * Gets the name of the field
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Filtration is expected to be run by the validate method before the validation takes place, and by default
     * only trims the passed value.
     *
     * Best practices for filtration are that the process only correct transmission or transcription errors. This
     * includes removing leading or trailing whitespace (as is done by default) or removing common formatting elements
     * such as non-integers from phone numbers.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function filter($value)
    {
        foreach ($this->filters as $filter) {
            $filter->filter($value);
        }
        return $value;
    }

    /**
     * This is the function that does the actual checking. This should allow either matches to the regex or empty
     * values.
     *
     * @param mixed $value The value being checked
     *
     * @return bool True if the value is valid
     */
    protected function checkValidity($value): bool
    {
        if (preg_match(static::$regex, $value)) {
            return true;
        } elseif ('' === $value) {
            return true;
        } else {
            return false;
        }
    }
}