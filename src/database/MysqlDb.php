<?php
namespace Vanilla\database;

class MysqlDb extends Database
{
    public function __construct($host, $database_name, $user, $password)
    {
        parent::__construct("mysql:host=$host;dbname=$database_name", $user, $password);
    }
}