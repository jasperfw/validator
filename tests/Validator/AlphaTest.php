<?php

namespace JasperFW\ValidatorTest\Validator;

use JasperFW\Validator\Exception\InvalidInputException;
use JasperFW\Validator\Validator\Alpha;
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    public function testQuickValidateValidValue()
    {
        $test_value = 'abc';
        $actual = Alpha::quickValidate($test_value);
        $this->assertEquals($test_value, $actual);
    }

    public function testQuickValidateInvalidValue()
    {
        $test_value = 'abc 123';
        $this->expectException(InvalidInputException::class);
        Alpha::quickValidate($test_value);
    }
}
