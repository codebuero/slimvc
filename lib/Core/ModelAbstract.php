<?php
namespace MyNamespace\Core;

abstract class ModelAbstract
{
    protected static $config = array();
    protected static $readAdapter = NULL;
    protected static $writeAdapter = NULL;

    const DB_CONNECTION_WRITE = 2; // 010
    const DB_CONNECTION_READ =  4; // 100
    const DB_CONNECTION_BOTH =  6; // 110

    public function __construct($config = array())
    {
        if ($config && is_array($config)) {
            self::$config = $config;
        }
    }

    protected function getConnection($type = self::DB_CONNECTION_BOTH)
    {
        // TODO implements connection instance in your way, here using PDO for example
        $dbConfig = self::$config['pdo']['default'];

        return new \PDO(
            $dbConfig['dsn'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['options']
        );
    }

    public function getReadConnection()
    {
        return $this->getConnection(self::DB_CONNECTION_READ);
    }

    public function getWriteConnection()
    {
        return $this->getConnection(self::DB_CONNECTION_WRITE);
    }
}