<?php

namespace JasperFW\Validator;

/**
 * Class ValidationError
 *
 * Handler for validation errors
 *
 * @package JasperFW\Validator
 */
class ValidationError
{
    /** @var string The name of the field */
    protected $fieldName;
    /** @var string The text of the error message */
    protected $errorMessage;

    /**
     * @param string $fieldName
     * @param string $errorMessage
     */
    public function __construct(string $fieldName, string $errorMessage)
    {
        $this->fieldName = $fieldName;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the name of the field
     *
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getErrorMessage();
    }
}