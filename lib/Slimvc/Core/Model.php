<?php
namespace Slimvc\Core;

/**
 * Base Abstract Model class
 *
 */
abstract class Model extends Object
{
    protected static $config = array();
    protected static $readAdapter = NULL;
    protected static $writeAdapter = NULL;

    const DB_CONNECTION_WRITE = 2; // 010
    const DB_CONNECTION_READ =  4; // 100
    const DB_CONNECTION_BOTH =  6; // 110

    /**
     * Constructor
     *
     * @param array $config the configurations
     */
    public function __construct($config = array())
    {
        if ($config && is_array($config)) {
            self::$config = $config;
        }
    }

    /**
     * Gets Database connection
     *
     * @param int $type the connection type
     *
     * @return \PDO
     */
    protected function getConnection($type = self::DB_CONNECTION_BOTH)
    {
        // TODO implements connection instance in your way, here using PDO for example
        $dbConfig = self::$config['pdo']['default'];

        $dbh = new \PDO(
            $dbConfig['dsn'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['options']
        );
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果
        $dbh->exec("SET NAMES 'utf8';");

        return $dbh;
    }

    /**
     * Gets Database read connection
     *
     * @return \PDO
     */
    public function getReadConnection()
    {
        if (static::$readAdapter === NULL) {
            static::$readAdapter = $this->getConnection(self::DB_CONNECTION_READ);
        }

        return static::$readAdapter;
    }

    /**
     * Gets Database write connection
     *
     * @return \PDO
     */
    public function getWriteConnection()
    {
        if (static::$writeAdapter === NULL) {
            static::$writeAdapter = $this->getConnection(self::DB_CONNECTION_WRITE);
        }

        return static::$writeAdapter;
    }

    /**
     * Gets Model instance
     *
     * @param array $config the configurations
     *
     * @return Model
     */
    public static function instance($config)
    {
        $className = get_called_class();
        return new $className($config);
    }
}