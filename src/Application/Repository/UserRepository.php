<?php

namespace App\Application\Repository;

use App\Domain\User\Document;
use App\Domain\User\Email;
use App\Domain\User\User;

interface UserRepository
{
    public function save(User $user): int;

    public function getByEmailAndDocument(Email $email, Document $document): User|null;
    public function get(int $userId): User|null;
    public function update(User $user): void;

}