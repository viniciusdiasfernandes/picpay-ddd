<?php

namespace App\Infra\Controller\Validator;

class IsSecure
{
    public static function validate(array $data, string $field): string
    {
        if (!isset($data[$field])) {
            return '';
        }
        $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
        if(!preg_match($pattern, $data[$field])) {
            return "The {$field} must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character";
        }
        return '';
    }
}