<?php

namespace Account\Domain;

interface Password
{
    public function validate(string $password);
}