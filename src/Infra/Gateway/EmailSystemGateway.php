<?php

namespace App\Infra\Gateway;

use App\Application\UseCases\DTO\MailerSendInput;
use App\Application\UseCases\DTO\MailerSendOutput;

class EmailSystemGateway implements MailerGateway
{

    public function send(MailerSendInput $input): MailerSendOutput
    {
        $urlSuccessTrue = "https://run.mocky.io/v3/2558afe3-d123-4b5a-b1aa-e25b7ed341db";
        $isEmailSent = json_decode(file_get_contents($urlSuccessTrue));
        return new MailerSendOutput(success: $isEmailSent->success);
    }
}