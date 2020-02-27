<?php

namespace JasperFW\Validator;

/**
 * Class InputSources
 *
 * @package JasperFW\Validator
 */
class InputSources
{
    /**
     * The value is being passed directly
     */
    const PASSED = 0;
    /**
     * The value is in the get array
     */
    const GET = 1;
    /**
     * The value is in the post array
     */
    const POST = 2;
    /**
     * The value is in either array
     */
    const EITHER = 3;
}