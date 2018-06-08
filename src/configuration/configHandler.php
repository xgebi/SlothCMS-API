<?php
/**
 * Configuration file handler
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
class ConfigHandler extends \SlothAdminApi\Helpers{
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
   * 
   * @param Array $headers
   * @param Object $body
   */
  public function get($headers, $body = NULL) {   
    if (file_exists($this->mainConfigFile)) {
      header("HTTP/1.0 200 OK", TRUE, 200);
      echo "{ \"notFound\" : false }";
    } else {      
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true }";
    }
  }

  /**
   * Function which handles POST method
   * 
   * @param Array $headers
   * @param Object data
   */
  public function post($headers, $data) {    
    if (file_exists($this->mainConfigFile) ||
        file_exists($this->usersConfigFile) ||
        file_exists($this->contentConfigFile)) {
      header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
      echo "{ \"configFilesCreated\" : false }";
      return NULL;
    }
    $overallWriteSuccess = true;

    if ($this->isJson($data)) {  
      
      $decodedData = \json_decode($data);
      
      if (property_exists($decodedData, "user")) {
        $users = new class {};
        $user = new class {};
        $user->username = $decodedData->user->adminUsername;
        $user->password = password_hash($decodedData->user->adminPassword, PASSWORD_BCRYPT);
        $user->name = $decodedData->user->adminName;
        $user->email = $decodedData->user->adminEmail;
        $users->list = array( $user );
        
        if (!file_put_contents($this->usersConfigFile, json_encode($users))) {
          $overallWriteSuccess = false;
        }
      }

      if (property_exists($decodedData, "website")) {    
        $websiteSettings = new class {};
        $websiteSettings->sitename = $decodedData->website->sitename;
        $websiteSettings->motto = $decodedData->website->subtitle;
        $websiteSettings->timeZone = date_default_timezone_get();
        if (!file_put_contents($this->mainConfigFile, json_encode($websiteSettings))) {
          $overallWriteSuccess = false;
        }
      }

      if (property_exists($decodedData, "content")) {
        if (!file_put_contents($this->contentConfigFile, json_encode($decodedData->content))) {
          $overallWriteSuccess = false;
        }
      } else if (!file_exists($this->contentConfigFile)) {
        if (!file_put_contents($this->contentConfigFile, file_get_contents(__DIR__ . '/sloth.content.default.json'))) {
          $overallWriteSuccess = false;
        }
      }

      if ($overallWriteSuccess) {
        header("HTTP/1.0 201 Created", TRUE, 201);
        echo "{ \"configFilesCreated\" : true }";
      } else {
        header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
        echo "{ \"configFilesCreated\" : false }";
      }
    } else {
      header("HTTP/1.0 405 Not Acceptable", TRUE, 405);
      echo "{ \"configFilesCreated\" : false }";
    }
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