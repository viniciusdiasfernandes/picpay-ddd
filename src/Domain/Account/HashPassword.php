<?php

namespace App\Domain\Account;

class HashPassword implements Password
{
    private function __construct(public string $value, public string $salt)
    {
    }

    public static function create(string $password): HashPassword
    {
        $value = password_hash($password, PASSWORD_DEFAULT);
        return new HashPassword($value, "");
    }

    public static function restore(string $password, string $salt): HashPassword
    {
		return new HashPassword($password, $salt);
	}
}