<?php

namespace JasperFW\Validator\Validator;

/**
 * Class Time
 *
 * Basic validator for time strings. Expects HH:MM, but doesn't do very much checking beyond that.
 * TODO: Improve this so much.
 *
 * @package JasperFW\Validator\Validator
 */
class Time extends Validator
{
    protected static $regex = '/^[0-9]{2}:[0-9]{2}+$/i';
}