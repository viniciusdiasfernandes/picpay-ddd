<?php
namespace Tests\unit;
use App\Domain\Account\PlainPassword;
use PHPUnit\Framework\TestCase;

class PlainPasswordTest extends TestCase
{
    public function testCreate()
    {
        $password = PlainPassword::create("test");
        $this->assertEquals("test", $password->value);
    }

    public function testRestore()
    {
        $password = PlainPassword::restore("test", "");
        $this->assertEquals("test", $password->value);
    }
}