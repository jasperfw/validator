<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class Required
 *
 * Add this constraint to fields that must contain a value.
 *
 * @package JasperFW\Validator\Constraint
 */
class Required extends Constraint
{
    /** @var string */
    protected $error_message = 'This field is required.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        if ('' === $value) {
            $this->reportError();
            return false;
        }
        return true;
    }
}