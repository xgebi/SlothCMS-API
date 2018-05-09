<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/router/router.php';
require_once __DIR__ . '/configuration/configChecker.php';
require_once __DIR__ . '/configuration/configHandler.php';
require_once __DIR__ . '/auth/authenticationHandler.php';
require_once __DIR__ . '/auth/logoutHandler.php';
require_once __DIR__ . '/auth/loggedInHandler.php';

$router = new SlothAdminAPI\Router\Router();

$router->registerRoute("/config/", ["GET"], "SlothAdminApi\Configuration\ConfigChecker");
$router->registerRoute("/config-file/", ["GET", "POST"], "SlothAdminApi\Configuration\ConfigHandler");
$router->registerRoute("/login/", ["POST"], "SlothAdminApi\Auth\AuthenticationHandler");
$router->registerRoute("/logout/", ["PUT"], "SlothAdminApi\Auth\LogoutHandler");
$router->registerRoute("/loggedIn/", ["PUT"], "SlothAdminApi\Auth\LoggedInHandler");

$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);