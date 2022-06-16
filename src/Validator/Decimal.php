<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Decimal
 *
 * Validator for strings that contain a number with a decimal.
 *
 * @package JasperFW\Validator\Validator
 */
class Decimal
{
    protected static string $regex = '/^[0-9]+(\./^[0-9]+)?$/i';
}
