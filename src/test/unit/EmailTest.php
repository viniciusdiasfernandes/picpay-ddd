<?php

namespace Account\unit;

use App\Domain\Account\Email;
use Exception;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = new Email("vinidiax@gmail.com");
        $this->assertEquals("vinidiax@gmail.com", $email->getValue());
    }

    public function testInvalidEmail()
    {
        $this->expectException(Exception::class);
        $email = new Email("vinidiax.gmail.com");
    }
}