<?php

namespace JasperFW\Validator\Validator;

/**
 * Class PhoneUS
 *
 * Validator for US phone numbers. Removes any leading 1 as well as dashes and parenthesis.
 *
 * @package JasperFW\Validator\Validator
 */
class PhoneUS extends Validator
{
    protected static $regex = '/^[0-9]{10}( ?x[0-9]+)?$/i';

    /**
     * Removes the leading one and common formatting characters from the passed phone number.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function filter($value): string
    {
        $value = parent::filter($value);
        return ltrim(str_replace(['(', ')', ' ', '-'], '', trim($value)), '1');
    }
}