<?php

namespace App\Domain\Account;

use Exception;

class DocumentFactory
{
    /**
     * @throws Exception
     */
    public static function generate(AccountType $type, string $document): Document
    {
        if($type === AccountType::Common) {
            return new Cpf($document);
        } else if($type  === AccountType::Merchant) {
            return new Cnpj($document);
        }
    }
}