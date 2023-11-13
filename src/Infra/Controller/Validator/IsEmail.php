<?php

namespace App\Infra\Controller\Validator;

class IsEmail
{
    public static function validate(array $data, string $field): string
    {
        if (empty($data[$field])) {
            return '';
        }
        if(!filter_var($data[$field], FILTER_VALIDATE_EMAIL))
        {
            return "{$data[$field]} is not a valid email address";
        }
        return '';
    }
}