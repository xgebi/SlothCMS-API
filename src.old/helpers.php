<?php
/**
 * Helpers object
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi;

/**
 * @package SlothAdminApi
 */
class Helpers {
  /**
   * Helper function for returning error responses
   * 
   * @param Integer HTTP status code
   * @param String HTTP status message
   */
  protected function sendResponse($code, $message) {
    header("$code $message", TRUE, $code);
    echo "{ \"errorCode\" : $code, \"errorMessage\": \"$message\" }";
  }
}