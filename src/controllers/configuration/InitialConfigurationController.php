<?php
/**
 * Class InitialConfigurationController
 *
 * Controller which handles initial configuration screen
 *
 * @package SlothCMS\Controllers\Configuration
 */

namespace SlothCMS\Controllers\Configuration;

require_once __DIR__ . "/../ControllerInterface.php";
require_once __DIR__ . "/../../models/Configuration.php";

use SlothCMS\Controllers\ControllerInterface;
use SlothCMS\Models\Configuration;

class InitialConfigurationController implements ControllerInterface {

    public function run() {
        if (empty($_POST)) {
            $this->serveForm();
        } else {
            $this->processParameters();
        }
    }

    private function serveForm($args = null) {
        readfile(__DIR__ . "/../../views/initial-configuration.html");
    }

    private function processParameters() {
        $siteName = filter_input(INPUT_POST, "site-name");
        $siteSubtitle = filter_input(INPUT_POST, "subtitle");
        $language = filter_input(INPUT_POST, "language");
        $adminUsername = filter_input(INPUT_POST, "admin-username");
        $adminPassword = filter_input(INPUT_POST, "admin-password");

        $configuration = new Configuration($siteName, $siteSubtitle, date_default_timezone_get(), "Y-n-j G:i", $language, [], "" );

        $configFileHandle = fopen(__DIR__ . "/../../../../sloth.conf.json", "w");
        $fwrite = fwrite($configFileHandle, $configuration->toJson());
        if (!$fwrite) {
            fclose($configFileHandle);
            // @TODO Add tickets for error handling
            $this->serveForm();
            return;
        }
        fclose($configFileHandle);

        header("Location: /login");
    }
}