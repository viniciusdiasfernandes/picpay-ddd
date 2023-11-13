<?php

namespace App\Infra\Controller;

use App\Application\UseCases\DTO\SignupInput;
use App\Application\UseCases\Signup;
use Exception;
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

    /**
     * @throws Exception
     */
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
            type: $payload->get('type')
        );
        try {
            $output = Signup::execute($input);
        } catch (ConflictingHeadersException $e) {
            return new JsonResponse(["Conflict" => $e->getMessage()], $e->getCode());
        } catch (BadRequestException $e) {
            return new JsonResponse(["Bad Request" => $e->getMessage()], $e->getCode());
        }
        return new JsonResponse($output, Response::HTTP_CREATED);
    }
}