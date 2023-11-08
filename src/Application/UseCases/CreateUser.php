<?php

namespace App\Application\UseCases;


use App\Application\Repository\UserRepository;
use App\Application\UseCases\DTO\CreateUserInput;
use App\Application\UseCases\DTO\CreateUserOutput;
use App\Domain\User\DocumentFactory;
use App\Domain\User\Email;
use App\Domain\User\HashPassword;
use App\Domain\User\User;
use App\Domain\User\UserType;
use App\Infra\DI\Registry;
use Exception;

class CreateUser
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function execute(CreateUserInput $input): CreateUserOutput
    {
        $type = UserType::from($input->type);
        if (!$input->type) {
            throw new Exception("Invalid user type");
        }
        $document = DocumentFactory::create($type, $input->document);
        $email = new Email($input->email);
        $user = Registry::getInstance()->get("userRepository")->getByEmailAndDocument($email, $document);
        if ($user) {
            throw new Exception("User already exists");
        }
        $user = User::create($input->firstName, $input->lastName, $document, $email, HashPassword::create($input->password), $type, 0);
        $accountId = Registry::getInstance()->get("userRepository")->save($user);
        return new CreateUserOutput(
            $user->firstName,
            $user->lastName,
            $user->document->getValue(),
            $user->email->getValue(),
            $type->value,
            0,
            $accountId
        );

    }
}