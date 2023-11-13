<?php

namespace App\Infra\Controller\Validator;

class ValidatorFactory
{
    public static function execute(string $rule, array $data, string $field, ...$params): string
    {
        if($rule === 'is_alphanumeric') {
            return IsAlphanumeric::validate($data, $field);
        }
        if($rule === 'is_between') {
            return IsBetween::validate($data, $field, ...$params);
        }
        if($rule === 'is_email') {
            return IsEmail::validate($data, $field);
        }
        if($rule === 'is_int') {
            return IsInt::validate($data, $field);
        }
        if($rule === 'is_max') {
            return IsMax::validate($data, $field, ...$params);
        }
        if($rule === 'is_min') {
            return IsMin::validate($data, $field, ...$params);
        }
        if($rule === 'is_same') {
            return IsSame::validate($data, $field, ...$params);
        }
        if($rule === 'is_secure') {
            return IsSecure::validate($data, $field);
        }
        if($rule === 'is_required') {
            return IsRequired::validate($data, $field);
        }
        if($rule === 'is_in') {
            return IsIn::validate($data, $field,...$params);
        }
        return '';
    }
}