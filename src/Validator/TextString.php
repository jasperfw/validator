<?php

namespace JasperFW\Validator\Validator;

/**
 * Class TextString
 *
 * Matches a single line of text. Use sanitizers and constraints to modify the requirements. If a multi-line string is
 * valid, use MultilineString validator instead.
 *
 * @package JasperFW\Validator\Validator
 */
class TextString extends Validator
{
    protected static $regex = '/^.*$/i';
}