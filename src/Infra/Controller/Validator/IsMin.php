<?php

namespace App\Infra\Controller\Validator;

class IsMin
{
    public static function validate(array $data, string $field, array $min): string
    {
        if (!isset($data[$field])) {
            return '';
        }
        if (strlen($data[$field]) < $min[0]) {
            return "The {$field} must have at least {$min[0]} characters";
        }
        return '';
    }
}