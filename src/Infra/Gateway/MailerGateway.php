<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\MailerSendInput;
use App\Application\UseCases\DTO\MailerSendOutput;

interface MailerGateway
{
    public function send(MailerSendInput $input): MailerSendOutput;
}