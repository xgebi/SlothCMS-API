<?php
/**
 * Content Management handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Content;

/**
 * Helpers object
 */
require_once(__DIR__ . '/../auth/authenticationHandler.php');

/**
 * @package SlothAdminApi\Configuration
 */
class ConntentManagementHandler extends \SlothAdminApi\Auth\AuthenticationHandler {
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
    
  }

  /**
   * Function which handles POST method
   * 
   * @param Object data
   */
  public function post($data) {    
    
  }

  /**
   * Function which handles PUT method
   * 
   * @param Object data
   */
  public function put($data) {    
    
  }

  /**
   * Function which handles DELETE method
   * 
   * @param Object data
   */
  public function delete($data) {    
    
  }

  /**
   * Function which detects if input string is JSON
   * 
   * @param String Possible JSON object
   */
  private function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
  }
}