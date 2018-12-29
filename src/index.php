<?php
/**
 * Created by PhpStorm.
 * User: Sarah Gebauer
 * Date: 2018-12-29
 * Time: 21:20
 */

namespace  SlothCMS;

require_once "router/Router.php";
require_once "controllers/HomeController.php";

use SlothCMS\Router\Router;
use SlothCMS\Controllers\HomeController;

$router = new Router();
$router->registerRoute("/", ['GET'], new HomeController(), 0, false);
$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);