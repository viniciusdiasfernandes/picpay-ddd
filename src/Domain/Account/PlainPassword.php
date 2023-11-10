<?php

namespace App\Domain\Account;

class PlainPassword implements Password
{
    private string $algorithm;

    private function __construct(readonly string $value, readonly string $salt)
    {
        $this->algorithm = "plain";
    }

    public static function create(string $password): PlainPassword
    {
        return new PlainPassword($password, "");
    }

    public static function restore(string $password, string $salt)
    {
        return new PlainPassword($password, $salt);
    }

}