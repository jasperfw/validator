<?php

namespace JasperFW\ValidatorTest;

use JasperFW\Validator\ValidationError;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidationErrorTest
 *
 * @package JasperFW\DataInterfaceTest\Validator
 */
class ValidationErrorTest extends TestCase
{
    public function testConstruct()
    {
        $field_name = 'field';
        $error_message = 'This is an error message';
        $error = new ValidationError($field_name, $error_message);
        $this->assertEquals($field_name, $error->getFieldName());
        $this->assertEquals($error_message, $error->getErrorMessage());
    }
}
