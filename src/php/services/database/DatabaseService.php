<?php


namespace slothcms\php\services\database;

require_once __DIR__ . './../../sloth-config.php';

class DatabaseService {
    private static $conn_string = "host=". DATABASE_URI ." port=".DATABASE_PORT." dbname=".DATABASE_NAME." user=".DATABASE_USER." password=".DATABASE_PASSWORD;

    private static $conn = null;

    public static function getConnection() {
        if (self::$conn == null) {
            self::$conn = pg_connect(self::$conn_string);
        }
        return self::$conn;
    }
}