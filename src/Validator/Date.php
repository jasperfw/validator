<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Date
 *
 * Accepts date and time strings. The string must be able to be parsed by DateTime. For a specific format, add a
 * DateFormat constraint.
 *
 * @package JasperFW\Validator\Validator
 */
class Date extends Validator
{
    /** @var string The default error message */
    protected $errorMessage = 'The date provided was not recognized.';

    /**
     * This is the function that does the actual checking. This should allow either matches to the regex or empty
     * values.
     *
     * @param $value
     *
     * @return bool
     */
    protected function checkValidity($value): bool
    {
        if ('' === $value) {
            return true;
        }
        $date = date_create($value);
        if (false === $date) {
            return false;
        }
        return true;
    }
}