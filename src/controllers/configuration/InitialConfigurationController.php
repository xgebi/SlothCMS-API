<?php
/**
 *  Controller which handles intial configuration screen
 */

namespace SlothCMS\Controllers\Configuration;

require_once __DIR__ . "/../ControllerInterface.php";

use SlothCMS\Controllers\ControllerInterface;

class InitialConfigurationController implements ControllerInterface {

    public function run() {
        $this->serveForm();
    }

    private function serveForm($args = null) {
        readfile(__DIR__ . "/../../views/initial-configuration.html");
    }
}