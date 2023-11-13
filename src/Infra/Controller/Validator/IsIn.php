<?php

namespace App\Infra\Controller\Validator;

class IsIn
{
    public static function validate(array $data, string $field, array $params): string
    {
        if (isset($data[$field], $params)) {
            if (!in_array($data[$field], $params)) {

                $params = implode(", ",$params);
                return "The {$field} must be in {$params}.";
            }
        }
        return '';
    }
}