<?php

namespace JasperFW\Validator\Validator;

/**
 * Class PostalCodeUS
 *
 * Validator for US postal codes, with or without the +4 designator.
 *
 * @package JasperFW\Validator\Validator
 */
class PostalCodeUS extends Validator
{
    protected static string $regex = '/^[0-9]{5}(\-[0-9]{4})?$/i';
}
