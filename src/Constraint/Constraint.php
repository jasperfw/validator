<?php

namespace JasperFW\Validator\Constraint;

use JasperFW\Validator\Exception\BadDefinitionException;
use JasperFW\Validator\Validator\Validator;

/**
 * Class Constraint
 *
 * Constraints represent additional rules or restrictions that might be placed on a value. For example, a validator
 * might only allow alphanumeric characters, but a constraint can then be added to specify a maximum length.
 *
 * @package JasperFW\Validator\Constraint
 */
abstract class Constraint
{
    protected $rule;
    protected $error_message;

    /** @var Validator */
    protected $validator;

    /**
     * Create a constraint according to the passed definition array. The definition must contain a class, which is the
     * fully qualified name of the constraint class. Optionally, it can also contain a rule value appropriate for the
     * constraint class in question, and an error message to override the default error message.
     *
     * @param array $definition
     *
     * @return Constraint|null
     * @throws BadDefinitionException If the definition file is not valid
     */
    public static function factory(array $definition): ?Constraint
    {
        // Make sure a class has been defined.
        if (!isset($definition['class'])) {
            throw new BadDefinitionException('The constraint could not be constructed.');
        }
        $class = $definition['class'];
        $rule = isset($definition['rule']) ? $definition['rule'] : null;
        $error_message = isset($definition['errorMessage']) ? $definition['errorMessage'] : null;
        return new $class($rule, $error_message);
    }

    /**
     * @param mixed     $rule          The value to check, if any
     * @param string    $error_message The error message to record on failure
     * @param Validator $validator     The validator this constraint is attached to
     */
    public function __construct($rule = null, ?string $error_message = null, ?Validator &$validator = null)
    {
        $this->rule = $rule;
        if (null != $error_message) {
            $this->error_message = $error_message;
        }
        $this->validator = $validator;
    }

    /**
     * Set a reference to the validator
     *
     * @param Validator $validator
     *
     * @return Constraint
     */
    public function setValidator(Validator &$validator): Constraint
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * Send the error to the validator if one is set
     */
    public function reportError(): void
    {
        if (isset($this->validator)) {
            $this->validator->reportError($this->error_message);
        }
    }

    /**
     * Get the defined error message for use if an error is encountered.
     */
    public function getErrorMessage(): string
    {
        return $this->error_message;
    }

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if it passes, false if not
     */
    abstract public function check($value): bool;
}