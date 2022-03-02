<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Phone
 *
 * Validates international phone numbers in the format +NNN NNNNNNNNNxNNNNN, with six or more digits, not counting the
 * country code, and an optional extension preceeded by an x. The x may have a space in front of it. The country code
 * may be 1 to 3 digits. No other punctuation or formatting characters are allowed.
 *
 * @package JasperFW\Validator\Validator
 */
class Phone extends Validator
{
    protected static string $regex = '/^\+[0-9]{1,3} [0-9]{6,} ?(x[0-9]+)?$/i';
}
