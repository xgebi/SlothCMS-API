<?php


namespace SlothCMS\controllers;

require_once __DIR__ . "ControllerInterface.php";


class BaseApiController implements ControllerInterface {
    public function run() {
        header("HTTP/1.0 501 Not Implemented");
        exit;
    }

    public function runApi() {
        // TODO: Implement runApi() method.
    }
}