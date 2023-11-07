<?php

namespace App\Domain\User;

enum UserType: string
{
    case Common = "common";
    case Merchant = "merchant";
}