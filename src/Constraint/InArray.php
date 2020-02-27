<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class InArray
 *
 * Add this constraint to fields that must contain a value from a list
 *
 * @package JasperFW\Validator\Constraint
 */
class InArray extends Constraint
{
    /** @var string */
    protected $error_message = 'The value provided is not valid.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        return (in_array($value, $this->rule));
    }
}