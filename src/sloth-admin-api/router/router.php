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
        foreach ($route->getAllowedMethods() as $routeMethod) {
          if ($method == $routeMethod) {
            $invalidMethod = false;

            $methodToCall = strtolower($method);
            $controllerClass = $route->getController();
            $controller = new $controllerClass($uri);
            
            if ($method == 'POST' || $method == 'PUT') {
              $body = file_get_contents("php://input");
              if ($body) {
                $controller->$methodToCall();
              } else {
                header("411 Length Required", TRUE, 411);
                echo "{ \"errorCode\" : 411, \"errorMessage\": \"Length Required\" }";
              }
            } else {
              $controller->$methodToCall();
            }

            break;
          }
        }       
      }
    }
    if ($invalidMethod && !$pathNotFound) {
      header("405 Method Not Allowed", TRUE, 405);
      echo "{ \"errorCode\" : 405, \"errorMessage\": \"Method Not Allowed\" }";
    }
    if ($pathNotFound) {
      header("404 Not Found", TRUE, 404);
      echo "{ \"errorCode\" : 404, \"errorMessage\": \"Not Found\" }";
    }
  }

  public function registerRoute($path, $methods, $controller) {
      $route = new Route($path, $methods, $controller);
      array_push($this->routes, $route);
  }
}