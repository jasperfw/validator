<?php

namespace JasperFW\Validator\Validator;

/**
 * Class AlphaNumeric
 *
 * For strings that contain letters and numbers.
 *
 * @package JasperFW\Validator\Validator
 */
class AlphaNumeric extends Validator
{
    protected static string $regex = '/^[a-zA-Z0-9]+$/i';
}
