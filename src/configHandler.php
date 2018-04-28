<?php
/**
 * Configuration file handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Configuration;

/**
 * @package SlothAdminApi\Configuration
 */
class ConfigHandler {
  private $mainConfigFile = "./sloth.conf.json";
  private $usersConfigFile = "./sloth.users.json";
  private $contentConfigFile = "./sloth.content.json";

  function __construct($uri) {
  }

  public function get() {    

    if (file_exists($this->mainConfigFile)) {
      header("HTTP/1.0 200 OK", TRUE, 200);
      echo file_get_contents($mainConfigFile);
    } else {      
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true }";
    }
  }

  public function post($data) {    
    if ($this->isJson($data)) {    
      if (file_put_contents($this->mainConfigFile, $data)) {
        header("HTTP/1.0 201 Created", TRUE, 201);
        echo "{ \"configFileCreated\" : true }";
      } else {
        header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
        echo "{ \"configFileCreated\" : false }";
      }
    } else {
      header("HTTP/1.0 405 Not Acceptable", TRUE, 405);
      echo "{ \"configFileCreated\" : false }";
    }
  }

  private function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
  }

  private function sendResponse($code, $message) {
    header("$code $message", TRUE, $code);
    echo "{ \"errorCode\" : $code, \"errorMessage\": \"$message\" }";
  }
}