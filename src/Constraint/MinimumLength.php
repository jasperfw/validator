<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class MinimumLength
 *
 * Verify that the value contains at least a certain number of characters.
 *
 * @package JasperFW\Validator\Constraint
 */
class MinimumLength extends Constraint
{
    /** @var string */
    protected $error_message = 'The value provided does not have enough characters.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        return (strlen($value) >= $this->rule);
    }
}