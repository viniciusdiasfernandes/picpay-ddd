<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\SignupInput;
use App\Infra\Controller\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

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

    public static function validate(Request $request): void
    {
        parent::execute($request->getPayload()->all(), self::$rules);
    }
}