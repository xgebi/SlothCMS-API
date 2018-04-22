<?php
namespace SlothAdminApi;

class Route {
  private $path;
  private $methodController = array(
    "GET" => NULL,
    "POST" => NULL,
    "PUT" => NULL,
    "DELETE" => NULL
  );

  function __construct($path, $method, $controller) {
    $this->path = $path;
    $this->methodController[$method] = $controller;
  }

  /**
   * Get the value of path
   */ 
  public function getPath()
  {
    return $this->path;
  }


  /**
   * Get the value of methodController
   */ 
  public function getMethodController()
  {
    return $this->methodController;
  }

  /**
   * Set the value of methodController
   *
   * @return  self
   */ 
  public function setMethodController($method, $controller) {
    $this->$path = $path;
    $this->$methodController[$method] = $controller;

    return $this;
  }
}