<?php

namespace Account\Domain;

enum UserType: string
{
    case Common = "common";
    case Merchant = "merchant";
}