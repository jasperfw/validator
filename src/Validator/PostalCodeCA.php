<?php

namespace JasperFW\Validator\Validator;

/**
 * Class PostalCodeCA
 *
 * Validator for Canadian postal codes.
 *
 * @package JasperFW\Validator\Validator
 */
class PostalCodeCA extends Validator
{
    protected static string $regex = '/^[A-Za-z][0-9][A-Za-z][ -]?[0-9][A-Za-z][0-9]$/i';
}
