<?php

namespace App\test\unit\Validator;

use App\Infra\Controller\Validator\IsEmail;
use App\Infra\Controller\Validator\IsIn;
use PHPUnit\Framework\TestCase;

class IsInTest extends TestCase
{
    public function testValidateNotSuccess()
    {
        $data = [
            "document" => "test"
        ];
        $output = IsIn::validate($data, "document",["common", "merchant"]);
        $this->assertIsString($output);
        $this->assertEquals("The document must be in common, merchant.", $output);
    }

    public function testValidateSuccess()
    {
        $data = [
            "document" => "common"
        ];
        $output = IsIn::validate($data, "document",["common", "merchant"]);
        $this->assertEmpty($output);
    }
}