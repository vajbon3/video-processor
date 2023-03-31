<?php
namespace Vanilla\database;

use PDO;

abstract class Database
{
    protected PDO $pdo;

    public function __construct($connection_string,$user,$password)
    {
        $this->pdo = new PDO($connection_string,$user,$password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function query(string $query,array $args) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($args);

        return $stmt;
    }
}