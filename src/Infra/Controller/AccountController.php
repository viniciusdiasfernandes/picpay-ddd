<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\Signup;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController
{
    public function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        CreateAccountValidator::validate($request);
        $payload = $request->getPayload();
        $input = new SignupInput(
            firstName: $payload->get('name'),
            lastName: $payload->get('lastName'),
            document: $payload->get('document'),
            email: $payload->get('email'),
            password: $payload->get('password'),
            type: $payload->get('type')
        );
        $output = Signup::execute($input);
        return new Response(json_encode($output), Response::HTTP_CREATED);
    }
}