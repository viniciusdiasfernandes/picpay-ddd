<?php

namespace App\Infra\Controller;

use App\Infra\Controller\Validator\Validator;

class CreateTransactionValidator extends Validator
{
    private static array $rules = [
        'amount' => 'required|int',
        'senderId' => 'required|int|min:1',
        'receiverId' => 'required|int|min:1'
    ];
    public function __construct()
    {
    }

    public static function validate($params): void
    {
        parent::execute($params, self::$rules);
    }
}