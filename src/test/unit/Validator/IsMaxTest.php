<?php

namespace App\test\unit\Validator;

use App\Infra\Controller\Validator\IsEmail;
use App\Infra\Controller\Validator\IsIn;
use App\Infra\Controller\Validator\IsInt;
use App\Infra\Controller\Validator\IsMax;
use PHPUnit\Framework\TestCase;

class IsMaxTest extends TestCase
{
    public function testValidateNotSuccess()
    {
        $data = [
            "name" => "test"
        ];
        $output = IsMax::validate($data, "name", 2);
        $this->assertIsString($output);
        $this->assertEquals("The name must have at most 2 characters", $output);
    }

    public function testValidateSuccess()
    {
        $data = [
            "name" => "test"
        ];
        $output = IsMax::validate($data, "name", 20);
        $this->assertEmpty($output);
    }

    public function testValidateEmptyValue()
    {
        $data = [];
        $output = IsMax::validate($data, "name", 20);
        $this->assertEmpty($output);
    }
}