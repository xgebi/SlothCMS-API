<?php
namespace SlothAdminApi;

class Route {
  private $path;
  private $allowedMethods;
  private $controller;

  function __construct($path, $methods, $controller) {
    $this->path = $path;
    $this->controller = $controller;
    $this->allowedMethods = $methods;
  }

  /**
   * Get the value of path
   */ 
  public function getPath()
  {
    return $this->path;
  }


  /**
   * Get the value of allowedMethods
   */ 
  public function getAllowedMethods()
  {
    return $this->allowedMethods;
  }

  /**
   * Get the value of controller
   */ 
  public function getController()
  {
    return $this->controller;
  }
}