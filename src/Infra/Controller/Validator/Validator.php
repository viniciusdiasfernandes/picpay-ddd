<?php

namespace App\Infra\Controller\Validator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Validator
{
    public static function execute(array $data, array $fields): void
    {
        // Split the array by a separator, trim each element
        // and return the array
        $split = fn($str, $separator) => array_map('trim', explode($separator, $str));
        // overwrite the default message
        $errors = [];
        foreach ($fields as $field => $option) {
            $rules = $split($option, '|');
            foreach ($rules as $rule) {
                // get rule name params
                $params = [];
                // if the rule has parameters e.g., min: 1
                if (strpos($rule, ':')) {
                    [$rule_name, $param_str] = $split($rule, ':');
                    $params = $split($param_str, ',');
                } else {
                    $rule_name = trim($rule);
                }
                // by convention, the callback should be is_<rule> e.g.,is_required
                $rule_name = explode(",",$rule_name)[0];
                $fn = 'is_'.$rule_name;
                $error = ValidatorFactory::execute($fn,$data, $field, $params);
                if (!empty($error)) {
                    $errors[] = $error;
                }
            }
        }
        if (count($errors) > 0) {
            $response = new JsonResponse(
                ["errors"=> $errors],
                Response::HTTP_BAD_REQUEST,
                ['content-type' => 'application/json']
            );
            $response->send();
        }
    }












}