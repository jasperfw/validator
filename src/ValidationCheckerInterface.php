<?php

namespace JasperFW\Validator;

use JasperFW\Validator\Validator\Validator;

/**
 * Interface ValidationCheckerInterface
 *
 * Users of the ValidationCheckerInterface use the validation checking functionality. As such, they provide methods for
 * the validation functions to report errors.
 *
 * @package JasperFW\Validator
 */
interface ValidationCheckerInterface
{
    /**
     * Add a validator to the class
     *
     * @param Validator $validator
     *
     * @return ValidationCheckerInterface
     */
    public function addValidator(Validator $validator): ValidationCheckerInterface;

    /**
     * Add a validation error message to the class
     *
     * @param ValidationError $validationError
     *
     * @return ValidationCheckerInterface
     */
    public function addValidationError(ValidationError $validationError): ValidationCheckerInterface;

    /**
     * Check if there were errors in the validation
     *
     * @return bool True if one or more validators have errors
     */
    public function hasErrors(): bool;

    /**
     * Get the error messages that were generated. Optionally pass true to only get one error per field.
     *
     * @param bool $allowMultipleErrors
     *
     * @return mixed
     */
    public function getErrors(bool $allowMultipleErrors);

    /**
     * Get the first error message associated with the field
     *
     * @param string $fieldName The name of the field
     *
     * @return string
     */
    public function getErrorByFieldName(string $fieldName): string;

    /**
     * Run all of the validators
     *
     * @return mixed
     */
    public function validate(): mixed;
}
