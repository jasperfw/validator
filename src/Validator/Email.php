<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Email
 *
 * Checks an e-mail address. This has been tested against ISO specifications and should allow any valid email address.
 * This validator checks the formatting only, it does not check the validity of the address, or the existance of the
 * account or domain/tld.
 *
 * @package JasperFW\Validator\Validator
 */
class Email extends Validator
{
    protected static $regex = '/^[a-z0-9._%+-]+@(?:[a-z0-9-]+\.)+[a-z]{2,4}$/i';

    /**
     * Filtration is expected to be run by the validate method before the validation takes place, and by default
     * only trims the passed value.
     *
     * Best practices for filtration are that the process only correct transmission or transcription errors. This
     * includes removing leading or trailing whitespace (as is done by default) or removing common formatting elements
     * such as non-integers from phone numbers.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function filter($value): string
    {
        $value = parent::filter($value);
        return strtolower(trim($value));
    }
}