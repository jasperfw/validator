<?php

namespace JasperFW\Validator;

use JasperFW\Validator\Exception\InvalidInputException;
use JasperFW\Validator\Validator\Validator;

/**
 * Class ValidationSet
 *
 * A validation set object contains the validators and provides a mechanism for iterating through them and chacking the
 * validity of each individual field.
 *
 * @package JasperFW\Validator
 */
class ValidationSet implements ValidationCheckerInterface
{
    /** @var Validator[] */
    private $validators = [];
    /** @var ValidationError[] */
    private $validationErrors = [];
    /** @var bool True if the validation has been run */
    private $validated = false;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param Validator $validator
     *
     * @return ValidationCheckerInterface
     */
    public function addValidator(Validator $validator): ValidationCheckerInterface
    {
        $this->validated = false;
        $validator->setValidationSet($this);
        array_push($this->validators, $validator);
        return $this;
    }

    /**
     * @param ValidationError $validationError
     *
     * @return ValidationCheckerInterface
     */
    public function addValidationError(ValidationError $validationError): ValidationCheckerInterface
    {
        array_push($this->validationErrors, $validationError);
        return $this;
    }

    /**
     * This is the opposite of the hasErrors method
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (false === $this->validated) {
            $this->validate();
        }
        return (count($this->validationErrors) === 0);
    }

    /**
     * This is the opposite of the isValid method
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        if (false === $this->validated) {
            $this->validate();
        }
        return (count($this->validationErrors) > 0);
    }

    /**
     * @param bool $allowMultipleErrors
     *
     * @return ValidationError[]
     */
    public function getErrors(bool $allowMultipleErrors = false): array
    {
        if (false === $this->validated) {
            $this->validate();
        }
        $returnedErrors = [];
        $fieldNames = [];

        if ($allowMultipleErrors) {
            $returnedErrors = $this->validationErrors;
        } else {
            foreach ($this->validationErrors as $error) {
                if (!in_array($error->getFieldName(), $fieldNames)) {
                    array_push($returnedErrors, $error);
                    array_push($fieldNames, $error->getFieldName());
                }
            }
        }
        return $returnedErrors;
    }

    /**
     * Returns an array of error messages, intended to be displayed in a list.
     *
     * @return array
     */
    public function getErrorMessages(): array
    {
        $errors = $this->getErrors(true);
        $return = [];
        foreach ($errors as $error) {
            $return[] = 'Field: ' . $error->getFieldName() . '| Message: ' . $error->getErrorMessage();
        }
        return $return;
    }

    /**
     * Check if a specific field is valid.
     *
     * @param string $fieldName
     *
     * @return bool
     */
    public function isFieldValid(string $fieldName): bool
    {
        if (false === $this->validated) {
            $this->validate();
        }
        return (false === $this->getErrorByFieldName($fieldName));
    }

    /**
     * @param string $fieldName
     *
     * @return string
     */
    public function getErrorByFieldName(string $fieldName): string
    {
        if (false === $this->validated) {
            $this->validate();
        }
        foreach ($this->validationErrors as $error) {
            if ($error->getFieldName() == $fieldName) {
                return $error->getErrorMessage();
            }
        }
        return '';
    }

    /**
     * Get the value associated with the field. If the field was not valid, returns null.
     *
     * @param string $fieldName The name of the field
     *
     * @return mixed The value of the field
     * @throws InvalidInputException If the field name does not exist
     */
    public function getFieldValue(string $fieldName)
    {
        if (false === $this->validated) {
            $this->validate();
        }
        foreach ($this->validators as $validator) {
            if ($validator->getFieldName() == $fieldName) {
                return $validator->getValue();
            }
        }
        throw new InvalidInputException('A field called ' . $fieldName . ' was not defined.');
    }

    /**
     * Validate the values based on the set validators.
     *
     * TODO: Should this return something or be made internal?
     */
    public function validate(): void
    {
        foreach ($this->validators as $validator) {
            $validator->validate();
        }
        $this->validated = true;
    }
}