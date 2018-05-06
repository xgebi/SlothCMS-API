<?php
/**
 * Logout handler handler
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
class LogoutHandler extends \SlothAdminApi\Helpers{
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
  public function put($user) {

    if (file_exists($this->usersConfigFile)) {
      $users = \json_decode(file_get_contents($this->usersConfigFile));
      $user = \json_decode($user);
      foreach ($users->list as $key => $value) {
        if ($value->username == $user->username) {        
          if ($user->token == $value->token) {
            $value->token = NULL;
            $value->validUntil = \time();
            $users->list[$key] = $value;
            file_put_contents($this->usersConfigFile, \json_encode($users));
          }
        }
      }
    }
    header("HTTP/1.0 200 OK", TRUE, 200);
    echo "{ \"loggedOut\" : true }";       
  }

}