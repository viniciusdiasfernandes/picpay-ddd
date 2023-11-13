<?php

namespace App\Infra\Controller;

use App\Infra\Controller\Validator\Validator;

class CreateAccountValidator extends Validator
{
    private static array $rules = [
        'name' => 'required,max:255',
        'lastName' => 'required,max:255',
        'document' => 'required|min:11',
        'email' => 'required|email',
        'password' => 'required|secure',
        'type' => 'required|in:common,merchant|max:255',
    ];

    public static function validate($params): void
    {
        parent::execute($params, self::$rules);
    }
}