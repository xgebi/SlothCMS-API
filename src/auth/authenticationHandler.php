<?php
namespace SlothAdminApi\Auth;

class AuthenticationHandler {
  private $usersConfigFile = __DIR__ . "/../../../sloth.users.json";
  /**
   * 
   */
  function __construct($uri) {
  }

  /**
   * 
   */
  function post($credentials) {
    $users = \json_decode(file_get_contents($usersConfigFile));
  }

  
}