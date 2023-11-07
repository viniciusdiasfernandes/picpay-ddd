<?php

namespace Account\Domain;

class PlainPassword implements Password
{
    private string $algorithm;

    private function __construct(readonly string $value, readonly string $salt)
    {
        $this->algorithm = "plain";
    }

    public function create(string $password): PlainPassword
    {
        return new PlainPassword($password, "");
    }

    public function restore(string $password, string $salt)
    {
        return new PlainPassword($password, $salt);
    }

    public function validate(string $password): bool
    {
        return $this->value === $password;
    }
}