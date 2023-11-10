<?php

namespace Tests\unit;

use App\Domain\Account\Account;
use App\Domain\Account\AccountType;
use App\Domain\Account\Cnpj;
use App\Domain\Account\Cpf;
use App\Domain\Account\Email;
use App\Domain\Account\HashPassword;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\integration\GenerateCnpj;
use Tests\integration\GenerateCpf;

class AccountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testAccountWithPermissionToTransfer()
    {
        $account = Account::create(
            firstName: "Test",
            lastName: "Test",
            document: new Cpf(GenerateCpf::cpfRandom()),
            email: new Email("vinidiax@gmail.com"),
            password: HashPassword::create("test"),
            type: AccountType::Common,
            balance:0
        );
        $this->assertTrue($account->isUserAllowedToTransfer());
    }

    /**
     * @throws Exception
     */
    public function testAccountWithoutPermissionToTransfer()
    {
        $account = Account::create(
            firstName: "Test",
            lastName: "Test",
            document: new Cnpj(GenerateCnpj::cnpjRandom()),
            email: new Email("vinidiax@gmail.com"),
            password: HashPassword::create("test"),
            type: AccountType::Merchant,
            balance:0
        );
        $this->assertFalse($account->isUserAllowedToTransfer());
    }

    /**
     * @throws Exception
     */
    public function testIsBalanceGreaterThenAmountToTransfer()
    {
        $account = Account::create(
            firstName: "Test",
            lastName: "Test",
            document: new Cnpj(GenerateCnpj::cnpjRandom()),
            email: new Email("vinidiax@gmail.com"),
            password: HashPassword::create("test"),
            type: AccountType::Merchant,
            balance:0
        );
        $this->assertFalse($account->isBalanceGreaterThenAmountToTransfer(500));
    }
}