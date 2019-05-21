<?php


namespace slothcms\php\services\auth;

require_once __DIR__ . "/../database/DatabaseService.php";

use slothcms\php\services\database\DatabaseService;

class AuthService {

    private $THIRTY_MINUTES_IN_SECONDS = 1800;

    private $conn;

    public function __construct() {
        $this->conn = DatabaseService::getConnection();
    }

    public function isAuthenticated($token) {
        if (!$token) {
            return false;
        }
        if ($this->conn) {
            $result = pg_query_params($this->conn, 'SELECT * FROM tokens WHERE token = $1 AND expiration <= $2', array($token, time()));
            if ($result) {
                pg_prepare($this->conn, "token_update", "UPDATE tokens SET expiration = $1 WHERE token = $2");
                $updatedToken = pg_execute($this->conn, "token_update", array(time() * $this->THIRTY_MINUTES_IN_SECONDS, $token));

                if ($updatedToken) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
}