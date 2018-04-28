<?php

/**
 * Route object
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Router;

/**
 * Route object
 */
require_once('route.php');

/**
 * @package SlothAdminApi\Router
 */
class Router {

  /**
   * @var String $basePath Base path for SlothCMS API
   */
  private $basePath = '/ext/slothcms/sloth-admin-api';

  /**
   * @var Array A list of routes
   */
  private $routes = [];

  /**
   * A function which starts routing
   * 
   * @param String $uri URI
   * @param String $method Request method
   */
  public function run($uri, $method) {
    /**
     * @var Boolean unknown URI
     */
    $pathNotFound = true;
    /**
     * @var Boolean HTTP method not supported for specified URI
     */
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
                $controller->$methodToCall($body);
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

  /**
   * Function which registers available routes
   * 
   * @param String path specific URI
   * @param Array methods available method for URI
   * @param Object controller which handles specific URI
   */
  public function registerRoute($path, $methods, $controller) {
      $route = new Route($path, $methods, $controller);
      array_push($this->routes, $route);
  }

  /**
   * Helper function for returning error responses
   * 
   * @param Integer HTTP status code
   * @param String HTTP status message
   */
  private function sendResponse($code, $message) {
    header("$code $message", TRUE, $code);
    echo "{ \"errorCode\" : $code, \"errorMessage\": \"$message\" }";
  }
}