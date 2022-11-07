<?php

namespace netvod\db;

use PDO;

class ConnectionFactory
{
    private static $db = null;
    private static $config = null;

    public static function setConfig($file)
    {
        if (file_exists($file)) self::$config = parse_ini_file($file);
    }

    public static function makeConnection()
    {
        if (self::$db != null) return self::$db;

        $dsn = self::$config['driver'] . ':host=' . self::$config['host'] . ';dbname=' . self::$config['database'];
        self::$db = new PDO($dsn, self::$config['username'], self::$config['password'], array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        return self::$db;
    }
}