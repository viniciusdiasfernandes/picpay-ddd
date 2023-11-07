<?php

namespace App\Domain\User;

interface Password
{
    public function validate(string $password);
}