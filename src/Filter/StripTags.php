<?php

namespace JasperFW\Validator\Filter;

/**
 * Class StripTags
 *
 * Removes any HTML tags from the submitted value.
 *
 * @package JasperFW\Validator\Filter
 */
class StripTags extends Filter
{

    public function filter(&$value)
    {
        $value = strip_tags($value);
    }
}