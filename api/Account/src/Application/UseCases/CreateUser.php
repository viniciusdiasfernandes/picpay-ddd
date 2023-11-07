<?php

namespace Account\Application\UseCases;

use Account\Application\Repository\UserRepository;
use Account\Application\UseCases\DTO\CreateUserInput;
use Account\Application\UseCases\DTO\CreateUserOutput;
use Account\Domain\Account;
use Account\Domain\AccountFactory;
use Account\Domain\DocumentFactory;
use Account\Domain\Email;
use Account\Domain\HashPassword;
use Account\Domain\User;
use Account\Domain\UserType;
use Exception;

class CreateUser
{
    public function __construct(readonly UserRepository $userRepository)
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
        $user = $this->userRepository->getByEmailAndDocument($email, $document);
        if ($user) {
            throw new Exception("User already exists");
        }
        $user = User::create($input->firstName, $input->lastName, $document, $email, HashPassword::create($input->password), $type, 0);
        $accountId = $this->userRepository->save($user);
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