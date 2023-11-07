<?php

namespace Payment\Infra\Database;

use mysqli;
use mysqli_result;

class MySqlPromiseAdapter implements Connection
{
    private mysqli $connection;
    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // error reporting
        $this->connection = new mysqli('picpay_mysql', 'root', 'test123', 'picpay');
        $this->connection->set_charset('utf8mb4'); // charset
    }
    public function query(string $statement, ?array $data = []): mysqli_result|bool
    {
        return $this->connection->execute_query($statement, $data);
    }

    public function getLastInsertedId(): int
    {
        return mysqli_insert_id($this->connection);
    }

    public function close(): void
    {
        $this->connection->close();
    }
}