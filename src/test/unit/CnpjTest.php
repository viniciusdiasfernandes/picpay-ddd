<?php

namespace Account\unit;

use App\Domain\Account\Cnpj;
use Exception;
use PHPUnit\Framework\TestCase;

class CnpjTest extends TestCase
{
    public function testCnpj()
    {
        $cnpj = new Cnpj("76.513.400/0001-62");
        $this->assertEquals("76.513.400/0001-62", $cnpj->getValue());
    }

    public function testWrongCnpj()
    {
        $this->expectException(Exception::class);
        new Cnpj("76.513.400/");
    }

    public function testEmpty()
    {
        $this->expectException(Exception::class);
        new Cnpj("");
    }

    public function testAllDigitsTheSame()
    {
        $this->expectException(Exception::class);
        new Cnpj("77.777.777/7777-77");
    }
}