<?php

namespace JasperFW\Validator\Constraint;

use DateTime;
use Exception;

/**
 * Class DateFormat
 *
 * Checks that the provided value is a recognizeable date and/or time format, using \DateTime
 *
 * @package JasperFW\Validator\Constraint
 */
class DateFormat extends Constraint
{
    protected $error_message = 'The value provided is not in a recognized format.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        try {
            if (false == DateTime::createFromFormat($this->rule, $value)) {
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}