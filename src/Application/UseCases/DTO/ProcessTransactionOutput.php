<?php

namespace App\Application\UseCases\DTO;

class ProcessTransactionOutput
{
    public function __construct(public bool $success)
    {

    }
}