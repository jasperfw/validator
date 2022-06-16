<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class MinimumValue
 *
 * Checks that the value is greater than or equal to the specified amount
 *
 * @package JasperFW\Validator\Constraint
 */
class MinimumValue extends Constraint
{
    /** @var string */
    protected string $error_message = 'The value provided is less than the minimum allowed value.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check(mixed $value): bool
    {
        return ($value <= $this->rule);
    }
}
