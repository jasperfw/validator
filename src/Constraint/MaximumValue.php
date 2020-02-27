<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class MaximumValue
 *
 * Check that the provided value is less than or equal to a certain amount.
 *
 * @package JasperFW\Validator\Constraint
 */
class MaximumValue extends Constraint
{
    protected $error_message = 'The value provided is greater than the maximum allowable value.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        return ($value <= $this->rule);
    }
}