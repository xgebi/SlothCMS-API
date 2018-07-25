<?php
/**
 * Handler which handles authentication
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
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
   * Function which handles POST method and serves as initial point around authentication
   * 
   * @param Array $headers
   * @param String $credentials is a JSON String
   * 
   */
  function post($headers, $credentials) {
    $user = $this->authenticate($credentials);
    if ($user) {
      header("200 OK", TRUE, 200);
      header("Authorization: Token $user->token");
      $responseBody = new class {};
      $responseBody->config = \json_decode(file_get_contents($this->mainConfigFile));
      $content = \json_decode(file_get_contents($this->contentConfigFile));
      $responseBody->post_types = $content->post_types;
      $responseBody->name = $user->name;
      $responseBody->user_name = $user->username;
      echo \json_encode($responseBody);
    } else {
      parent::sendResponse(403, "Forbidden");  
    }
  }

  /**
   * Function decodes user JSON and checks if the users is among users. 
   * Optionally generate access token
   * 
   * @param String $user is JSON string representing user's credentials
   */
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
          return $value;
        } else {
          return NULL;
        }
      }
    }
  }


  /**
   * Functions checks if user is currently authenticated against the
   * database of users
   * 
   * @param String $username
   * @param String $token
   */
  function isAuthenticated($username, $token) {
    $users = \json_decode(file_get_contents($this->usersConfigFile));
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