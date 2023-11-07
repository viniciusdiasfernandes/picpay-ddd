<?php

namespace Account\unit;

use App\Domain\User\Cnpj;
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
}