<?php
/**
 * Route object
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Router;

/**
 * @package SlothAdminApi\Router
 */
class Route {
  /**
   * @var String $path URL path
   */
  private $path;
  /**
   * @var Array $allowedMethods array of allowed methods
   */
  private $allowedMethods;
  /**
   * @var Object $controller Object which handles requests
   */
  private $controller;

  /**
   * Constructor of Route object
   * 
   * @param String $path URL path
   * @param Array $methods Array of methods such as GET, POST etc.
   * @param Object $controller An object which handles requests for certain paths
   */
  function __construct($path, $methods, $controller) {
    $this->path = $path;
    $this->controller = $controller;
    $this->allowedMethods = $methods;
  }

  /**
   * Get the value of path
   * 
   * @return String URL path
   */ 
  public function getPath()
  {
    return $this->path;
  }


  /**
   * Get the value of allowedMethods
   * 
   * @return Array Methods implemented for calls to certain path
   */ 
  public function getAllowedMethods()
  {
    return $this->allowedMethods;
  }

  /**
   * Get the value of controller
   * 
   * @return Object An object which handles calls
   */ 
  public function getController()
  {
    return $this->controller;
  }
}