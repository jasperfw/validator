<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Number
 *
 * Represents a string that should only contain digits.
 *
 * @package JasperFW\Validator\Validator
 */
class Number extends Validator
{
    protected static string $regex = '/^[0-9]+$/i';
}
