<?php

namespace App\Application\UseCases\DTO;

class MailerSendOutput
{
    public function __construct(
        public bool $success
    )
    {
    }
}