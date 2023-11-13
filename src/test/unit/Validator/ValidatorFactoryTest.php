<?php

namespace App\test\unit\Validator;

use App\Infra\Controller\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorFactoryTest extends TestCase
{
    public function testValidateIsAlphanumeric()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|alphanumeric'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsBetween()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|between:1,2'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsEmail()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|email'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsInt()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|int'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsMax()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|max:10'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsMin()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|min:10'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsSame()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|same:test'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsSecure()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|secure'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateIsIn()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => 'required|in:test,test2'
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }

    public function testValidateReturningEmpty()
    {
        $data = [
            "name" => "test"
        ];
        $rules = [
            'name' => ''
        ];
        Validator::execute($data, $rules);
        $this->assertTrue(true);
    }
}