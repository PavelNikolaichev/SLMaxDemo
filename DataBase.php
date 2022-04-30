<?php
/**
 * Автор: Николайчев Павел
 *
 * Дата реализации: 30.04.2022 10:00
 *
 * Дата изменения: 30.04.2022 19:15
 */


/**
 * DataBase class that is used to connect to db.<br/>
 * $conn - connection with the database, using PDO.<br/>
 * $instance - instance of the class.
 */
class DataBase
{
    public PDO $conn;
    private static $instance;

    /**
     * Connect to the database.<br/>
     * Note: This is a private constructor, so nobody can create a new instance.<br/>
     * Note 2: I have not used config files because right now that is unnecessary.
     */
    private function __construct()
    {
        $dsn = 'mysql:host=db;dbname=TestTask;port=3306;connect_timeout=15';

        $user = "root";
        $password = "root";

        $this->conn = new PDO($dsn, $user, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Returns the connection to the database.
     * @return mixed
     */
    public static function getConnection(): PDO
    {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance->conn;
    }
    }