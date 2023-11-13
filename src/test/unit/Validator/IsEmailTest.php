<?php

namespace App\test\unit\Validator;

use App\Infra\Controller\Validator\IsEmail;
use PHPUnit\Framework\TestCase;

class IsEmailTest extends TestCase
{
    public function testValidateNotSuccess()
    {
        $data = [
            "email" => "test"
        ];
        $isValidEmail = IsEmail::validate($data, "email");
        $this->assertIsString($isValidEmail);
        $this->assertEquals("test is not a valid email address", $isValidEmail);
    }

    public function testValidateSuccess()
    {
        $data = [
            "email" => "vinidiax@gmail.com"
        ];
        $isValidEmail = IsEmail::validate($data, "email");
        $this->assertEmpty($isValidEmail);
    }

    public function testValidateEmptyValue()
    {
        $data = [];
        $isValidEmail = IsEmail::validate($data, "email");
        $this->assertEmpty($isValidEmail);
    }
}