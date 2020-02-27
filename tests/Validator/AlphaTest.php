<?php

namespace JasperFW\ValidatorTest\Validator;

use JasperFW\DataInterface\Validator\Exception\InvalidInputException;
use JasperFW\DataInterface\Validator\Validator\Alpha;
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    /**
     * @throws InvalidInputException
     */
    public function testQuickValidateValidValue()
    {
        $test_value = 'abc';
        $actual = Alpha::quickValidate($test_value);
        $this->assertEquals($test_value, $actual);
    }

    /**
     * @throws InvalidInputException
     */
    public function testQuickValidateInvalidValue()
    {
        $test_value = 'abc 123';
        $this->expectException(InvalidInputException::class);
        Alpha::quickValidate($test_value);
    }
}
