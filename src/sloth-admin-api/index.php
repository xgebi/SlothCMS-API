<?php

require_once './router/router.php';
require_once './configChecker.php';

$router = new SlothAdminAPI\Router();

$router->registerRoute("/config/", "GET", SlothAdminAPI\ConfigChecker::class);

$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);