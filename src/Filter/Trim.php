<?php

namespace JasperFW\Validator\Filter;

/**
 * Class Trim
 *
 * Trims the passed value, removing white space from the beginning and end of the string.
 *
 * @package JasperFW\Validator\Filter
 */
class Trim extends Filter
{

    public function filter(&$value)
    {
        $value = trim($value);
    }
}