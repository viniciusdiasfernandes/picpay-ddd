<?php

namespace Account\Domain;

use Exception;

class DocumentFactory
{
    /**
     * @throws Exception
     */
    public static function create(UserType $type, string $document): Document
    {
        if($type === UserType::Common) {
            return new Cpf($document);
        } else if($type  === UserType::Merchant) {
            return new Cnpj($document);
        }
        throw new Exception("Invalid document type");
    }
}