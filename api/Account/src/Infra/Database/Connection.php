<?php

namespace Account\Infra\Database;

interface Connection
{
    public function query(string $statement, ?array $data = null);
    public function close(): void;

    public function getLastInsertedId(): int;
}