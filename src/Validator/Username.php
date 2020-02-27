<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Username
 *
 * Basic username validation. Accepts any characters by default, except newlines.
 *
 * @package JasperFW\Validator\Validator
 */
class Username extends Validator
{
    protected static $regex = '/^.+$/i';
}