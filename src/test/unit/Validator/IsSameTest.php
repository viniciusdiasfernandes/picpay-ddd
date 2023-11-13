<?php

namespace App\test\unit\Validator;

use App\Infra\Controller\Validator\IsMax;
use App\Infra\Controller\Validator\IsMin;
use App\Infra\Controller\Validator\IsRequired;
use App\Infra\Controller\Validator\IsSame;
use PHPUnit\Framework\TestCase;

class IsSameTest extends TestCase
{
    public function testValidateNotSuccess()
    {
        $data = [
            "name" => "testing"
        ];
        $output = IsSame::validate($data, "name", ["test"]);
        $this->assertIsString($output);
        $this->assertEquals("The name must match with test", $output);
    }

    public function testValidateSuccess()
    {
        $data = [
            "name" => "test"
        ];
        $output = IsSame::validate($data, "name",["test"]);
        $this->assertEmpty($output);
    }
}