<?php

class Config
{
    /** Parameters for Db conection */
    public static $host = '127.0.0.1';
    public static $dbname = 'unilimes_test';
    public static $userName = 'root';
    public static $password = 'andre0991';

    /** Parameters for display message about numbers of string to upload ti dataBase */
    public static $period = '1000';
    public static $displayMessage = true;
    public static $perPage = '10';
    public static $page = '1';

    /** Parameters PDO */
    public static function dBConfig () {
        $dBConfig = [
            'dsn' => 'mysql:host=' . self::$host . ';dbname=' . self::$dbname,
            'username' => self::$userName,
            'password' => self::$password
        ];

        $db = new PDO($dBConfig['dsn'], $dBConfig['username'], $dBConfig['password']);

        return $db;
    }
}



