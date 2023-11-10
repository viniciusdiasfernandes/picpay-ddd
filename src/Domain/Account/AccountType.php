<?php

namespace App\Domain\Account;

enum AccountType: string
{
    case Common = "common";
    case Merchant = "merchant";
}