<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\CreateUserInput;
use App\Application\UseCases\DTO\CreateUserOutput;
use App\Infra\DI\Registry;
use Exception;
use stdClass;

class UserController
{
    public function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(array $params): CreateUserOutput
    {
        CreateUserValidator::validate($params);
        $input = new CreateUserInput(
            firstName: $params['name'],
            lastName: $params['lastName'],
            document: $params['document'],
            email: $params['email'],
            password: $params['password'],
            type: $params['type']
        );
        return Registry::getInstance()->get('createUser')->execute($input);
    }
}