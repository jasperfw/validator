<?php

namespace JasperFW\Validator\Constraint;

/**
 * Class Regex
 *
 * The value must match the specified regex.
 *
 * @package JasperFW\Validator\Constraint
 */
class Regex extends Constraint
{

    /**
     * @inheritDoc
     */
    public function check(mixed $value): bool
    {
        return preg_match($this->rule, $value);
    }
}
