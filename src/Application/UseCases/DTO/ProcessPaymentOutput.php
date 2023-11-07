<?php

namespace App\Application\UseCases\DTO;

class ProcessPaymentOutput
{
    public function __construct(public bool $success)
    {
    }
}