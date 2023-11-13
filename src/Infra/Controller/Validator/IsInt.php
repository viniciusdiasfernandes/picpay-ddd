<?php

namespace App\Infra\Controller\Validator;

class IsInt
{
    public static function validate($data, $field): string
    {
        if(!isset($data[$field])) {
            return '';
        }
        if(!is_int($data[$field])) {
            return "The {$field} should be integer";
        }
        return '';
    }
}