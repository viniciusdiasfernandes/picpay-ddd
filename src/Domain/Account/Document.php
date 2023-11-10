<?php

namespace App\Domain\Account;

interface Document
{
    public function getValue(): string;
}