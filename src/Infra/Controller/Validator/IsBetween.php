<?php

namespace App\Infra\Controller\Validator;

class IsBetween
{
    public static function validate(array $data, string $field, $params): string
    {
        $min = $params[0];
        $max = $params[1];
        if (!isset($data[$field])) {
            return '';
        }
        $len = strlen($data[$field]);
        if(!($len >= $min && $len <= $max)) {
            return "The {$field} must have between {$min} and {$max} characters";
        }
        return '';
    }
}