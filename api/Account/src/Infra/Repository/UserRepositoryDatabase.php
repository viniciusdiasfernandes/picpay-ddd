<?php

namespace Account\Infra\Repository;

use Account\Application\Repository\UserRepository;
use Account\Domain\Document;
use Account\Domain\DocumentFactory;
use Account\Domain\Email;
use Account\Domain\HashPassword;
use Account\Domain\User;
use Account\Domain\UserType;
use Account\Infra\Database\Connection;
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

    public function addBalance(User $user): void
    {
        $this->connection->query(statement: "UPDATE picpay.user SET balance = '{$user->getBalance()}' WHERE id = {$user->id}");
    }
}