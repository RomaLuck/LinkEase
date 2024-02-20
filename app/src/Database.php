<?php

namespace Src;

use PDO;
use PDOStatement;

class Database
{
    public PDO $connection;

    public function __construct($dsn, $username, $password)
    {
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = []): false|PDOStatement
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}