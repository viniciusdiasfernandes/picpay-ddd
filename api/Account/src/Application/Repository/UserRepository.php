<?php

namespace Account\Application\Repository;

use Account\Domain\Document;
use Account\Domain\Email;
use Account\Domain\User;

interface UserRepository
{
    public function save(User $user): int;

    public function getByEmailAndDocument(Email $email, Document $document): User|null;
    public function get(int $userId): User|null;

}