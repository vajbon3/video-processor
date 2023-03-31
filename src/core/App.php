<?php
namespace Vanilla\core;

use Vanilla\database\Database;
use Vanilla\database\MysqlDb;
use Vanilla\utils\Bag;

class App
{
    public static string $project_root;
    public static Router $router;
    public static IRequest $request;
    public static Bag $bag;
    public static Database $db;

    // initialize static properties
    public static function init(array $config): void
    {
        self::$project_root = dirname(__DIR__,2);
        self::$router = new Router();
        self::$request = new Request();
        self::$bag = new Bag();

        // database initiation with passed database config
        $db_config = $config['database'];
        self::$db = new MysqlDb(
            $db_config['hostname'],
            $db_config['name'],
            $db_config['user'],
            $db_config['password']);
    }
}