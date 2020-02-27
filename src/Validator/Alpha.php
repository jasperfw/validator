<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Alpha
 *
 * For strings that can only contain letters. This allows for both upper and lower case letters.
 *
 * @package JasperFW\Validator\Validator
 */
class Alpha extends Validator
{
    protected static $regex = '/^[a-zA-Z]+$/i';
}