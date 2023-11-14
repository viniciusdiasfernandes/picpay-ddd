<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\Signup;
use App\Domain\Account\AccountType;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Exception\ConflictingHeadersException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController
{
    public function __construct(
    )
    {
    }

    public function create(Request $request): JsonResponse
    {
        CreateAccountValidator::validate($request);
        $payload = $request->getPayload();
        $input = new SignupInput(
            firstName: $payload->get('name'),
            lastName: $payload->get('lastName'),
            document: $payload->get('document'),
            email: $payload->get('email'),
            password: $payload->get('password'),
            type: AccountType::from($payload->get('type'))
        );
        try {
            $output = Signup::execute($input);
        } catch (Exception $e) {
            return new JsonResponse(["Error" => $e->getMessage()], $e->getCode());
        }
        return new JsonResponse($output, Response::HTTP_CREATED);
    }
}