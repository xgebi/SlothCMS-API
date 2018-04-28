<?php
/**
 * Configuration checker handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Configuration;

/**
 * @package SlothAdminApi\Configuration
 */
class ConfigChecker {
  function __construct($uri) {
  }

  public function get() {
    $filename = "./sloth.conf.json";

    if (file_exists($filename)) {
      header("HTTP/1.0 200 OK", TRUE, 200);
      echo "{ \"notFound\" : false }";
    } else {      
      if (\is_writable("./")) {
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true, \"notWritable\" : false }";
      } else {
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true, \"notWritable\" : true }";
      }
    }    
  }

  private function sendResponse($code, $message) {
    header("$code $message", TRUE, $code);
    echo "{ \"errorCode\" : $code, \"errorMessage\": \"$message\" }";
  }
}