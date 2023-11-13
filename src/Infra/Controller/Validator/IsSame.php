<?php

namespace App\Infra\Controller\Validator;

class IsSame
{
    public static function validate(array $data, string $field, array $params): string
    {
        if (isset($data[$field], $params)) {
            if($data[$field] !== $params[0]) {
                return "The {$field} must match with {$params[0]}";
            }
        }
        return '';
    }
}