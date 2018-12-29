<?php
/**
 * LoggedIn handler
 * 
 * Checks if user is logged in and prolongs session
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Auth;

/**
 * Helpers object
 */
require_once(__DIR__ . '/../helpers.php');

/**
 * @package SlothAdminApi\Configuration
 */
class LoggedInHandler extends \SlothAdminApi\Helpers{
  private $usersConfigFile = __DIR__ . "/../../../sloth.users.json";

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
  public function put($headers, $user = NULL) {
    $headersSent = false;    

    if (strlen($headers['authorization']) > 0) {
      $authHeader = explode(" ",$headers['authorization']);

      if (file_exists($this->usersConfigFile)) {
        $users = \json_decode(file_get_contents($this->usersConfigFile));

        foreach ($users->list as $key => $value) {
          if ($value->username == $authHeader[0]) {        
            if (($authHeader[1] == $value->token) && ($value->validUntil >= \time())) {
              $value->validUntil = \time() + (30 * 60);
              $users->list[$key] = $value;
              file_put_contents($this->usersConfigFile, \json_encode($users));
              $headersSent = true;
              header("HTTP/1.0 200 OK", TRUE, 200);
              echo "{ \"loggedOut\" : false }";  
            } else {
              $headersSent = true;
              header("HTTP/1.0 401 Unauthorized", TRUE, 401);
              echo "{ \"loggedOut1\" : true }"; 
            }
          }
        }        
      }     
    }
    if (!$headersSent) {
      header("HTTP/1.0 401 Unauthorized", TRUE, 401);
      echo "{ \"loggedOut2\" : true }";  
    }
  }

}