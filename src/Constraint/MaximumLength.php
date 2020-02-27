<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class MaximumLength
 *
 * Verifies that the value contains a certain number of characters.
 *
 * @package JasperFW\Validator\Constraint
 */
class MaximumLength extends Constraint
{
    protected $error_message = 'The value provided has too many characters.';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value
     *
     * @return bool True if it passes, false if not
     */
    public function check($value): bool
    {
        return (strlen($value) <= $this->rule);
    }
}