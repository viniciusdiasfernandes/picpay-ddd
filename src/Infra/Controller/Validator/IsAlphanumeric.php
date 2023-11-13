<?php

namespace App\Infra\Controller\Validator;

class IsAlphanumeric
{
    public static function validate(array $data, string $field): string
    {
        if (!isset($data[$field])) {
            return '';
        }
        if(ctype_alnum($data[$field])) {
            return "The {$field} should have only letters and numbers";
        }
        return '';
    }
}