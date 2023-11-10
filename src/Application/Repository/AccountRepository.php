<?php

namespace App\Application\Repository;

use App\Domain\Account\Document;
use App\Domain\Account\Email;
use App\Domain\Account\Account;

interface AccountRepository
{
    public function save(Account $account): int;
    public function getByEmailAndDocument(Email $email, Document $document): Account|null;
    public function get(int $accountId): Account|null;
    public function update(Account $account): void;

}