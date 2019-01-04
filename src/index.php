<?php
/**
 * Created by PhpStorm.
 * User: Sarah Gebauer
 * Date: 2018-12-29
 * Time: 21:20
 */

namespace  SlothCMS;

require_once __DIR__ . "/router/Router.php";
require_once __DIR__ . "/controllers/HomeController.php";
require_once __DIR__ . "/controllers/configuration/InitialConfigurationController.php";

use SlothCMS\Router\Router;
use SlothCMS\Controllers\HomeController;
use SlothCMS\Controllers\Configuration\InitialConfigurationController;

$router = new Router();
$router->registerRoute("/conf", ['GET', 'POST'], new InitialConfigurationController(), 0, false);
$router->registerRoute("/", ['GET'], new HomeController(), 0, false);
$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);