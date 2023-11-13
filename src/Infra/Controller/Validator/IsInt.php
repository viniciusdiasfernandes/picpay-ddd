<?php

namespace App\Infra\Controller\Validator;

class IsInt
{
    public static function validate($data, $field): string
    {
        if(!is_int($data[$field])) {
            return "The {$field} should be integer";
        }
        return '';
    }
}