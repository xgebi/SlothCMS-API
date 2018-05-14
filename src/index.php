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
require_once __DIR__ . '/content/contentManagementHandler.php';

$router = new SlothAdminAPI\Router\Router();
$authenticator = new SlothAdminAPI\Auth\AuthenticationHandler();
$headers = getallheaders();

if (array_key_exists('Authorization', $headers)) {
  $authHeader = explode(" ",$headers['Authorization']);

  if ($authenticator->isAuthenticated($authHeader[0], $authHeader[1])) {
    $router->registerRoute("/logout/", ["PUT"], "SlothAdminApi\Auth\LogoutHandler");
    $router->registerRoute("/loggedIn/", ["PUT"], "SlothAdminApi\Auth\LoggedInHandler");
    $router->registerRoute("/post/", ["GET", "POST", "PUT", "DELETE"], "SlothAdminApi\Content\ContentManagementHandler");
    $router->registerRoute("/posts/", ["GET"], "SlothAdminApi\Content\ContentManagementHandler");
    $router->registerRoute("/config-file/", ["GET", "PUT"], "SlothAdminApi\Configuration\ConfigHandler");
  }
} else {
  $router->registerRoute("/config/", ["GET"], "SlothAdminApi\Configuration\ConfigChecker");
  $router->registerRoute("/login/", ["POST"], "SlothAdminApi\Auth\AuthenticationHandler");
  $router->registerRoute("/config-file/", ["GET", "POST"], "SlothAdminApi\Configuration\ConfigHandler");
}

$router->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);