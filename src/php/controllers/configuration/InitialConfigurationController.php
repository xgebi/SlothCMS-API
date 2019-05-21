<?php
/**
 * Class InitialConfigurationController
 *
 * Controller which handles initial configuration screen
 *
 * @package SlothCMS\Controllers\Configuration
 */

namespace slothcms\controllers\configuration;

require_once __DIR__ . "/../ControllerInterface.php";
require_once __DIR__ . "/../../models/Configuration.php";
require_once __DIR__ . "/../../models/Users.php";
require_once __DIR__ . "/../../models/User.php";

use slothcms\Controllers\ControllerInterface;
use slothcms\Models\Configuration;
use slothcms\Models\User;
use slothcms\Models\Users;

class InitialConfigurationController implements ControllerInterface {

    public function run() {
        if (empty($_POST)) {
            $this->serveForm();
        } else {
            $this->processParameters();
        }
    }

    public function runApi() {
        header("HTTP/1.0 501 Not Implemented");
        exit;
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

        if ($this->createConfigFile($siteName, $siteSubtitle, $language) &&
            $this->createUsersFile($adminUsername, $adminPassword)) {
            header("Location: /login");
        }
        // @TODO Add tickets for error handling
        $this->serveForm();
    }

    private function createConfigFile($siteName, $siteSubtitle, $language) {
        $configuration = new Configuration($siteName, $siteSubtitle, date_default_timezone_get(), "Y-n-j G:i", $language, [], "" );

        $configFileHandle = fopen(__DIR__ . "/../../../sloth.conf.json", "w");
        $fwrite = fwrite($configFileHandle, $configuration->toJson());
        fclose($configFileHandle);
        if (!$fwrite) {
            return false;
        }
        return true;
    }

    private function createUsersFile($adminUsername, $adminPassword) {
        $user = new User($adminUsername, password_hash($adminPassword, PASSWORD_BCRYPT), null, null, 0);
        $users = new Users();
        $users->addUser($user);

        $configFileHandle = fopen(__DIR__ . "/../../../sloth.users.json", "w");
        $fwrite = fwrite($configFileHandle, $users->toJson());
        fclose($configFileHandle);
        if (!$fwrite) {
            return false;
        }
        return true;
    }
}