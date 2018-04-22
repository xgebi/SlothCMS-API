<?php
namespace SlothAdminAPI;

require_once('route.php');

class Router {

  private $basePath = '/sloth-admin-api';

  private $routes = [];

  public function run($uri, $method) {
    $uri = trim($uri, $basePath);
    $pathNotFound = true;
    $invalidMethod = true;    

    foreach ($this->routes as $route) {
      
      if (preg_match($route->getPath(), $uri)) {
        $pathNotFound = false;
        foreach ($route->getMethodController() as $routeMethod => $routeController) {
          if (($method == $routeMethod) &&!is_null($routeController)) {
            $invalidMethod = false;

            $methodToCall = strtolower($method);

            $controller = new $routeController($uri);
            $controller->$methodToCall();

            break;
          }
        }
        if ($invalidMethod && !$pathNotFound) {
          header("405 Method Not Allowed", TRUE, 405);
        }
        if ($pathNotFound) {
          header("404 Not Found", TRUE, 404);
        }

      }
    }
  }

  public function registerRoute($path, $method, $controller) {
    $route = new Route($path, $method, $controller);
    array_push($this->routes, $route);
  }
}