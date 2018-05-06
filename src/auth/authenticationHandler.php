<?php
namespace SlothAdminApi\Auth;

class AuthenticationHandler extends \SlothAdminApi\Helpers {
  private $usersConfigFile = __DIR__ . "/../../../sloth.users.json";

  private $mainConfigFile = __DIR__ . "/../../../sloth.conf.json";
  private $contentConfigFile = __DIR__ . "/../../../sloth.content.json";
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