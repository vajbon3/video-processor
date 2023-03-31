<?php
$servername=getenv('HOSTNAME');
$username=getenv('USER');
$password=getenv('PASS');

try {
    // initiate connection
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // create database
    $sql = "CREATE DATABASE IF NOT EXISTS vanilla";
    $conn->exec($sql);
    $sql = "use vanilla";
    $conn->exec($sql);

    // TABLES
    $sql = "DROP TABLE IF EXISTS media;";
    $conn->exec($sql);

    $sql = "CREATE TABLE media (
                id int AUTO_INCREMENT PRIMARY KEY,
                filepath varchar(255),
                name varchar(255),
                duration int NULL,
                media_type tinyint,
                thumbnail varchar(255)
                );";
    $conn->exec($sql);

    $sql = "CREATE INDEX media_media_type_index on media (media_type);";
    $conn->exec($sql);

    // success message
    echo "migration successful";
}
// error message
catch(PDOException $e)
{
    echo $e->getMessage();
}