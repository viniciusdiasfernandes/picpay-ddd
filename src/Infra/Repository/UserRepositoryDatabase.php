<?php

namespace App\Infra\Repository;

use App\Application\Repository\UserRepository;
use App\Domain\User\Document;
use App\Domain\User\DocumentFactory;
use App\Domain\User\Email;
use App\Domain\User\HashPassword;
use App\Domain\User\User;
use App\Domain\User\UserType;
use App\Infra\Database\Connection;
use Exception;

readonly class UserRepositoryDatabase implements UserRepository
{
    public function __construct(public Connection $connection)
    {
    }

    public function save(User $user): int
    {
        $this->connection->query(
            "INSERT INTO picpay.user (name, last_name, document, email, password, type, balance) 
            VALUES ('{$user->firstName}', '{$user->lastName}', '{$user->document->getValue()}', '{$user->email->getValue()}', '{$user->password->value}', '{$user->type->value}', {$user->getBalance()})");
        return $this->connection->getLastInsertedId();
    }

    /**
     * @throws Exception
     */
    public function getByEmailAndDocument(Email $email, Document $document): User|null
    {
        $user = $this->connection->query("SELECT * FROM picpay.user WHERE email = '{$email->getValue()}' OR document = '{$document->getValue()}'")->fetch_object();
        if (!$user) {
            return null;
        }
        $type = UserType::from($user->type);
        $document = DocumentFactory::create($type, $user->document);
        return User::restore($user->name, $user->last_name, $document, new Email($user->email), HashPassword::restore($user->password, ""), $type, $user->balance, $user->id);
    }

    /**
     * @throws Exception
     */
    public function get(int $userId): User|null
    {
        $user = $this->connection->query("SELECT * FROM picpay.user WHERE id = {$userId}")->fetch_object();
        if (!$user) {
            return null;
        }
        $type = UserType::from($user->type);
        $document = DocumentFactory::create($type, $user->document);
        return User::restore($user->name, $user->last_name, $document, new Email($user->email), HashPassword::restore($user->password, ""), $type, $user->balance, $user->id);
    }

    public function update(User $user): void
    {
        $this->connection->query(statement: "UPDATE picpay.user SET name = '{$user->firstName}', last_name = '{$user->lastName}', document = '{$user->document->getValue()}', email = '{$user->email->getValue()}', type = '{$user->type->value}', balance = {$user->getBalance()} WHERE id = {$user->id}");
    }

}