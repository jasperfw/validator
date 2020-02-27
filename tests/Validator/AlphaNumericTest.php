<?php

namespace JasperFW\ValidatorTest\Validator;

use JasperFW\Validator\Constraint\MaximumLength;
use JasperFW\Validator\Exception\InvalidInputException;
use JasperFW\Validator\Validator\AlphaNumeric;
use PHPUnit\Framework\TestCase;

class AlphaNumericTest extends TestCase
{
    /**
     * @throws InvalidInputException
     */
    public function testQuickValidateValidValue()
    {
        $test_value = 'abc123';
        $actual = AlphaNumeric::quickValidate($test_value);
        $this->assertEquals($test_value, $actual);
    }

    /**
     * @throws InvalidInputException
     */
    public function testQuickValidateInvalidValue()
    {
        $test_value = 'abc 123';
        $this->expectException(InvalidInputException::class);
        AlphaNumeric::quickValidate($test_value);
    }

    /**
     * @throws InvalidInputException
     */
    public function testQuickValidateViolatesConstraint()
    {
        $test_value = 'abc_123';
        $constraint = new MaximumLength(3);
        $this->expectException(InvalidInputException::class);
        AlphaNumeric::quickValidate($test_value, [$constraint]);
    }

    /**
     * @throws InvalidInputException
     */
    public function testValidateForFormValidValue()
    {
        $test_value = 'abc123';
        $actual = AlphaNumeric::quickValidate($test_value);
        $this->assertEquals($test_value, $actual);
    }

    /**
     * @throws InvalidInputException
     */
    public function testValidateForFormInvalidValue()
    {
        $test_value = 'abc 123';
        $this->expectException(InvalidInputException::class);
        AlphaNumeric::quickValidate($test_value);
    }
}
