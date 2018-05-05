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
 * Helpers object
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * @package SlothAdminApi\Router
 */
class Router extends \SlothAdminApi\Helpers {

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
            
            $body = file_get_contents("php://input");
            if ($method == 'POST' || $method == 'PUT') {              
              if ($body) {
                $controller->$methodToCall($body);
              } else {
                parent::sendResponse(411, "Length Required");
              }
            } else {
              $controller->$methodToCall($body);
            }

            break;
          }
        }       
      }
    }
    if ($invalidMethod && !$pathNotFound) {
      parent::sendResponse(405, "Method Not Allowed");    
    }
    if ($pathNotFound) {
      parent::sendResponse(404, "Not Found");
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
}