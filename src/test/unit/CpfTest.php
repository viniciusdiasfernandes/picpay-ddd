<?php

namespace Account\unit;

use App\Domain\Account\Cpf;
use Exception;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
    /** @dataProvider cpfProvider
     * @throws Exception
     */
    public function testValidCpf(array $input)
    {
        $cpf = new Cpf($input["cpf"]);
        $this->assertEquals($input["cpf"], $cpf->getValue());
    }
    public function testCpfWithWrongLength()
    {
        $this->expectException(Exception::class);
        new Cpf("958.187.055");
    }

    public function testCpfWithSameNumbers()
    {
        $this->expectException(Exception::class);
        new Cpf("999.999.999-99");
    }

    public function testEmptyCpf()
    {
        $this->expectException(Exception::class);
        new Cpf("");
    }

    public function cpfProvider(): array
    {
        return [
            "Valid cpf 1" => [
                "input" => [
                    "cpf" => "565.486.780-60"
                ]
            ],
            "Valid cpf 2" => [
                "input" => [
                    "cpf" => "95818705552"
                ]
            ]
        ];
    }
}