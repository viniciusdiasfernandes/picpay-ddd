<?php

namespace App\Infra\Controller;

use App\Application\UseCases\Signup;
use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\DTO\SignupOutput;
use App\Infra\DI\Registry;
use Exception;
use stdClass;

class AccountController
{
    public function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $params): SignupOutput
    {
        CreateAccountValidator::validate($params);
        $input = new SignupInput(
            firstName: $params['name'],
            lastName: $params['lastName'],
            document: $params['document'],
            email: $params['email'],
            password: $params['password'],
            type: $params['type']
        );
        return Signup::execute($input);
    }
}