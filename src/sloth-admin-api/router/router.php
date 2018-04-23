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
                sendResponse(411, "Length Required");
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
      sendResponse(405, "Method Not Allowed");    
    }
    if ($pathNotFound) {
      sendResponse(404, "Not Found");
    }
  }

  public function registerRoute($path, $methods, $controller) {
      $route = new Route($path, $methods, $controller);
      array_push($this->routes, $route);
  }

  private function sendResponse($code, $message) {
    header("$code $message", TRUE, $code);
    echo "{ \"errorCode\" : $code, \"errorMessage\": \"$message\" }";
  }
}