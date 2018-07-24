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
 * Autoload of CouchDB
 */
require(__DIR__ .  '/../../../lib/autoload.php');

use PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions\CouchException;
use PHPOnCouch\CouchDocument;

/**
 * @package SlothAdminApi\Configuration
 */
class ConfigHandler extends \SlothAdminApi\Helpers{
  private $mainConfigFile = __DIR__ . "/../../../sloth.conf.json";

  private $couchDsn = "http://admin:admin@localhost:5984/"; // this will need to be changed through configuration
  private $userDB = "users";
  private $contentTypesDB = "contentTypes";
  private $contentDB = "content";

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
  function post($headers, $data) {    
    if (file_exists($this->mainConfigFile)) {
      header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
      echo "{ \"configFilesCreated\" : false }";
      return NULL;
    }
    $overallWriteSuccess = true;

    if ($this->isJson($data)) {  
      
      $decodedData = \json_decode($data);
      
      if (property_exists($decodedData, "user")) {
        $user = new class {};
        $user->username = $decodedData->user->adminUsername;
        $user->password = password_hash($decodedData->user->adminPassword, PASSWORD_BCRYPT);
        $user->name = $decodedData->user->adminName;
        $user->email = $decodedData->user->adminEmail;
        
        try {
          $couchDB = new CouchClient($this->couchDsn, $this->userDB);
          $couchDB->createDatabase();
          $userDocument = new CouchDocument($couchDB);
          $userDocument->set($user);
        } catch (CouchException $e) {
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

      try {
        $couchDB = new CouchClient($this->couchDsn, $this->contentTypesDB);
        $couchDB->createDatabase();
        $couchDB = new CouchClient($this->couchDsn, $this->contentDB);
        $couchDB->createDatabase();
      } catch (CouchException $e) {
          $overallWriteSuccess = false;
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