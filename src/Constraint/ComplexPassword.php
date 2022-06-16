<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class ComplexPassword
 *
 * A complex password requiring at least one letter, one number and one special character. Use with the Min and Max
 * length constraints to enforce password length.
 *
 * @package JasperFW\Validator\Constraint
 */
class ComplexPassword extends Constraint
{
    protected string $error_message = 'The password must contain at least 3 of the 4: A capital letter, a lower case character, a number, a special character.';

    protected string $pattern = '/(?=^.{6,255}$)((?=.*\d)(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[^A-Za-z0-9])(?=.*[a-z])|(?=.*[^A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z])|(?=.*\d)(?=.*[A-Z])(?=.*[^A-Za-z0-9]))^.*/i';

    /**
     * Check the constraint. Child classes should attempt to report the error to the validator.
     *
     * @param mixed $value The value to check
     *
     * @return bool True if it passes, false if not
     */
    public function check(mixed $value): bool
    {
        return preg_match($this->pattern, $value);
    }
}
