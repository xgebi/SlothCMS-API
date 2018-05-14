<?php
/**
 * Configuration checker handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Configuration;

/**
 * Helpers object
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * @package SlothAdminApi\Configuration
 */
class ConfigChecker extends \SlothAdminApi\Helpers{
  private $mainConfigFile = __DIR__ . "/../../../sloth.conf.json";
  private $usersConfigFile = __DIR__ . "/../../../sloth.users.json";
  private $contentConfigFile = __DIR__ . "/../../../sloth.content.json";
  /**
   * Constructor function
   * 
   * @param String URI
   */
  function __construct($uri) {
  }

  /**
   * Function which handles GET method
   */
  public function get($body = NULL) {

    if (file_exists($this->mainConfigFile) &&
        file_exists($this->usersConfigFile) &&
        file_exists($this->contentConfigFile)) {
      header("HTTP/1.0 200 OK", TRUE, 200);
      echo "{ \"notFound\" : false }";
    } else {      
      if (\is_writable(__DIR__ . "/../../")) {
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        $response = new class {};
        $response->notFound = true;
        $response->notWrittable = false;        
        echo json_encode($response);        
      } else {
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true, \"notWritable\" : true }";
      }
    }    
  }

}