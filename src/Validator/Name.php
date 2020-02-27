<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Name
 *
 * Validates names containing Latin characters. Allows letters, dashes and apostrophes.
 *
 * @package JasperFW\Validator\Validator
 */
class Name
{
    protected static $regex = '/^[a-zA-Z\-\' ]+$/i';
}