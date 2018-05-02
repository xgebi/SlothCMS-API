<?php
namespace SlothAdminApi\Auth;

class AuthenticationHandler {
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
    $this->authenticate($credentials);
  }

  function authenticate($user) {
    $users = \json_decode(file_get_contents($usersConfigFile));
    foreach ($users->list as $key => $value) {
      if ($value->username == $user->username) {
        if (password_verify($user->password, $value->password)) {
          $value->token = bin2hex(\random_bytes(64));
          $value->validUntil = \time() + (30 * 60);
          $users->list[$key] = $value;
          return true;
        } else {
          return false;
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