<?php

require_once './router/router.php';
require_once './configChecker.php';
require_once './configHandler.php';

$router = new SlothAdminAPI\Router();

$router->registerRoute("/config/", ["GET"], "SlothAdminAPI\ConfigChecker");
$router->registerRoute("/config-file/", ["GET", "POST"], "SlothAdminAPI\ConfigHandler");

$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);