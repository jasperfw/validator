<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Password
 *
 * This class allows any character. For a complex password that requires a complex combination of characters, use the
 * ComplexPassword validator. Use length constraints to force minimum and maximum lengths.
 *
 * @package JasperFW\Validator\Validator
 */
class Password extends Validator
{
    protected static $regex = '/^.*$/i';
}