<?php
namespace Tests\unit;
use App\Domain\Account\AccountType;
use App\Domain\Account\Cnpj;
use App\Domain\Account\Cpf;
use App\Domain\Account\DocumentFactory;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\integration\GenerateCnpj;
use Tests\integration\GenerateCpf;

class DocumentFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGenerateCpf()
    {
        $cpf = GenerateCpf::cpfRandom();
        $document = DocumentFactory::generate(AccountType::Common, $cpf);
        $this->assertInstanceOf(Cpf::class, $document);
        $this->assertEquals($cpf, $document->getValue());
    }

    /**
     * @throws Exception
     */
    public function testGenerateCnpj()
    {
        $cnpj = GenerateCnpj::cnpjRandom();
        $document = DocumentFactory::generate(AccountType::Merchant, $cnpj);
        $this->assertInstanceOf(Cnpj::class, $document);
        $this->assertEquals($cnpj, $document->getValue());
    }
}