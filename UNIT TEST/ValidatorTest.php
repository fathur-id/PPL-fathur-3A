
<?php
// File: ValidatorTest.php

use PHPUnit\Framework\TestCase;

require_once 'Validator.php';

class ValidatorTest extends TestCase
{
    public function testValidateAge()
    {
        $this->assertTrue(validateAge(30));
        $this->assertTrue(validateAge(-30));
    }

    public function testEmptyAgeThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        validateAge(" ");
    }
}