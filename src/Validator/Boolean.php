<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Boolean
 *
 * Class allows true or false, or Y or N
 *
 * @package JasperFW\Validator\Validator
 */
class Boolean extends Validator
{
    protected static string $regex = '/^(true|false|Y|N)$/i';
}
