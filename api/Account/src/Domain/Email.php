<?php

namespace Account\Domain;

use Exception;

class Email
{
    private string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid e-mail");
        }
        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}