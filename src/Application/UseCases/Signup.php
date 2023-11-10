<?php

namespace App\Application\UseCases;

use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\DTO\SignupOutput;
use App\Domain\Account\Account;
use App\Domain\Account\AccountType;
use App\Domain\Account\DocumentFactory;
use App\Domain\Account\Email;
use App\Domain\Account\HashPassword;
use App\Infra\DI\Registry;
use Exception;
use ValueError;

class Signup
{
    /**
     * @throws Exception
     */
    public static function execute(SignupInput $input): SignupOutput
    {
        try {
            $type = AccountType::from($input->type);
        } catch (ValueError) {
            throw new Exception("Invalid account type");
        }
        $document = DocumentFactory::generate($type, $input->document);
        $email = new Email($input->email);
        $isAccountAlreadyCreated = Registry::getInstance()->get("accountRepository")->getByEmailAndDocument($email, $document);
        if ($isAccountAlreadyCreated) {
            throw new Exception("User already exists");
        }
        $account = Account::create($input->firstName, $input->lastName, $document, $email, HashPassword::create($input->password), $type, 0);
        $accountId = Registry::getInstance()->get("accountRepository")->save($account);
        return new SignupOutput(
            $account->firstName,
            $account->lastName,
            $account->document->getValue(),
            $account->email->getValue(),
            $type->value,
            0,
            $accountId
        );

    }
}