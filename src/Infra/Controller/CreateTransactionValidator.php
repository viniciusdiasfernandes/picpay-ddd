<?php

namespace App\Infra\Controller;

use App\Infra\Controller\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

class CreateTransactionValidator extends Validator
{
    private static array $rules = [
        'amount' => 'required|int|min:1',
        'senderId' => 'required|int|min:1',
        'receiverId' => 'required|int|min:1'
    ];

    public static function validate(Request $request): void
    {
        parent::execute($request->getPayload()->all(), self::$rules);
    }
}