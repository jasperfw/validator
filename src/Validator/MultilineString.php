<?php

namespace JasperFW\Validator\Validator;

/**
 * Class MultilineString
 *
 * Validates a generic string of text that spans multiple lines. Note that it will not fail a single line string.
 *
 * @package JasperFW\Validator\Validator
 */
class MultilineString extends Validator
{
    protected static $regex = '/^.*$/mi';
}