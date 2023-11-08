<?php

namespace App\Infra\Controller;

class CreateUserValidator extends Validator
{
    private static array $rules = [
        'name' => 'required,max:255',
        'lastName' => 'required,max:255',
        'document' => 'required|min:11, max:25',
        'email' => 'required|email',
        'password' => 'required|secure',
        'type' => 'required|max:255',
    ];

    public static function validate($params): void
    {
        $errors = parent::execute($params, self::$rules);
        if (count($errors) > 0) {
            header('Content-Type: application/json; charset=utf-8');
            header("HTTP/1.0 400 Bad Request");
            echo json_encode($errors);
            die();
        }
    }

}