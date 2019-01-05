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

use slothcms\router\Router;
use slothcms\controllers\HomeController;
use slothcms\controllers\configuration\InitialConfigurationController;
use slothcms\controllers\authorization\LoginController;

$router = new Router();
$router->registerRoute("/conf", ['GET', 'POST'], new InitialConfigurationController(), 0, false);
$router->registerRoute("/login", ['GET', 'POST'], new LoginController(), 0, false);
$router->registerRoute("/", ['GET'], new HomeController(), 0, false);
$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);