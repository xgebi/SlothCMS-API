<?php
namespace SlothAdminApi\Auth;

class AuthenticationHandler extends \SlothAdminApi\Helpers {
  private $usersConfigFile = __DIR__ . "/../../../sloth.users.json";
  private $users;
  
  /**
   * Constructor function
   * 
   * @param String URI
   */
  function __construct($uri = null) {
  }

  /**
   * 
   */
  function post($credentials) {
    $result = $this->authenticate($credentials);
    if (\strlen($result) > 0) {
      header("200 OK", TRUE, 200);
      header("Authorization: Token $result");
      echo "{ \"errorCode\" : 200, \"errorMessage\": \"OK\" }"; 
    } else {
      parent::sendResponse(403, "Forbidden");  
    }
  }

  function authenticate($user) {
    $this->users = \json_decode(file_get_contents($this->usersConfigFile));
    $user = \json_decode($user);
    foreach ($this->users->list as $key => $value) {
      if ($value->username == $user->username) {        
        if (\password_verify($user->password, $value->password)) {
          $value->token = \bin2hex(\random_bytes(64));
          $value->validUntil = \time() + (30 * 60);
          $this->users->list[$key] = $value;
          file_put_contents($this->usersConfigFile, \json_encode($this->users));
          return $value->token;
        } else {
          return "";
        }
      }
    }
  }


  function isAuthenticated($username, $token) {
    $users = \json_decode(file_get_contents($usersConfigFile));
    foreach ($users->list as $key => $value) {
      if ($value->username == $username) {
        if ($value->token == $token && $value->validUntil >= \time()) {
          $value->validUntil = \time() + (30 * 60);
          $users->list[$key] = $value;
          return true;
        } else {
          return false;
        }
      }
    }
  }

  
}