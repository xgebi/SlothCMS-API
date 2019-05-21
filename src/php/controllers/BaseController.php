<?php


namespace slothcms\controllers;

require_once __DIR__ . "/ControllerInterface.php";
require_once __DIR__ . "/../services/auth/AuthService.php";

class BaseController implements ControllerInterface {
    public function run() {
        // TODO: Implement run() method.
    }

    public function runApi() {
        header("HTTP/1.0 501 Not Implemented");
        exit;
    }


}