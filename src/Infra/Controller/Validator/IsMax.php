<?php

namespace App\Infra\Controller\Validator;

class IsMax
{
    public static function validate(array $data, string $field, $max): string
    {
        if (!isset($data[$field])) {
            return '';
        }
        if (strlen($data[$field]) <= $max) {
            return '';
        }
        return "The {$field} must have at most {$max} characters";
    }
}