<?php
/**
 * Created by PhpStorm.
 * User: Sarah Gebauer
 * Date: 2018-12-29
 * Time: 21:20
 */

namespace  slothcms;

require_once __DIR__ . "/router/Router.php";
require_once __DIR__ . "/controllers/HomeController.php";
require_once __DIR__ . "/controllers/configuration/InitialConfigurationController.php";
require_once __DIR__ . "/controllers/authorization/LoginController.php";
require_once __DIR__ . "/controllers/general/DashboardController.php";
require_once __DIR__ . "/services/auth/AuthService.php";

use slothcms\controllers\authorization\LoginController;
use slothcms\controllers\configuration\InitialConfigurationController;
use slothcms\controllers\general\DashboardController;
use slothcms\controllers\HomeController;
use slothcms\router\Router;


session_start();
$router = new Router();

$_SESSION['test'] = "hello";

if (file_exists("sloth-config.php")) {
    $router->registerRoute("/dashboard", ['GET'], new DashboardController(), 1, false);
    $router->registerRoute("/login", ['GET', 'POST'], new LoginController(), 0, false);
    $router->registerRoute("/", ['GET'], new HomeController(), 1, false);
} else {
    $router->registerRoute("/conf", ['GET', 'POST'], new InitialConfigurationController(), 0, false);
}
$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
