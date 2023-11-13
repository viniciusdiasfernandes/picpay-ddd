<?php

namespace App\Infra\Controller\Validator;

class IsRequired
{

    public static function validate(array $data, string $field): string
    {
        if(isset($data[$field]) && trim($data[$field]) !== '') {
            return '';
        }
        return "The {$field} is required";
    }
}