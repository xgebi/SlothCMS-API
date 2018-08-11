<?php
/**
 * Content Management handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Content;

/**
 * Helpers object
 */
require_once(__DIR__ . '/../auth/authenticationHandler.php');

/**
 * @package SlothAdminApi\Configuration
 */
class ContentManagementHandler {
  const CONTENT_CONFIG_FILE = __DIR__ . "/../../../sloth.content.json";
  const CONTENT_DIRECTORY = __DIR__ . "/../../../sloth-content";
  const META_CONTENT_FILE = self::CONTENT_DIRECTORY . "/sloth-meta.json";

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
  public function get($body = NULL) {   
    
  }

  /**
   * Function which handles POST method
   * 
   * @param Object data
   */
  public function post($headers, $postTypeEntry) {    
    $postTypeEntry = json_decode($postTypeEntry);
    // open file with meta data of stored content
    if (file_exists(self::META_CONTENT_FILE)) {
      $data = json_decode(file_get_contents(self::META_CONTENT_FILE));
    } else {
      $data = new class{};
      $data->list = [];
    }
    // check if slug is unique, if not add number, increase until it's unique slug
    $postTypeEntry->slug = $this->clean($postTypeEntry->title);
    $regexpPattern = "/" . $postTypeEntry->slug . "-?[0-9]*/";
    $entries = [];
    foreach ($data->list as $entry) {            
      if (preg_match($regexpPattern, $entry->slug)) {
        $entries[] = $entry;
      }
    }
    if (\count($entries) > 0) {
      $postTypeEntry->slug .= "-" . \count($entries);
    }    
    // save file
    if (!\file_exists(self::CONTENT_DIRECTORY)) {
      if (is_writable(self::CONTENT_DIRECTORY)) {
      mkdir(self::CONTENT_DIRECTORY);
      } else {
        header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
        echo "{ \"folderError\" : true }";
        return NULL;
      }
    }
    if (mkdir(self::CONTENT_DIRECTORY . "/" . $postTypeEntry->slug)) {
      if (file_put_contents(self::CONTENT_DIRECTORY . "/" . $postTypeEntry->slug . "/content.json", json_encode($postTypeEntry))) {
        // update meta data
        $newEntry = new class {};
        $newEntry->slug = $postTypeEntry->slug;
        $newEntry->path = $postTypeEntry->slug . "/content.json";
        $newEntry->state = "to-publish";

        $data->list[] = $newEntry;
        if (file_put_contents(self::CONTENT_DIRECTORY . "/sloth-meta.json", json_encode($data))) {
          // return 201
          header("HTTP/1.0 201 Created", TRUE, 201);
          echo \json_encode($postTypeEntry);
        } else {
          header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
          echo "{ \"metaFileError\" : true }";
        }
      } else {
        header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
        echo "{ \"contentFileError\" : true }";
      }
    } else {
      header("HTTP/1.0 500 Internal Server Error", TRUE, 500);
      echo "{ \"contentFileError\" : true }";
    }
    
  }

  /**
   * Function which handles PUT method
   * 
   * @param Object data
   */
  public function put($postTypeEntry) {    
    $postTypeEntry = json_decode($postTypeEntry);
    // open file with meta data of stored content
    if (file_exists(self::META_CONTENT_FILE)) {
      $data = json_decode(file_get_contents(self::META_CONTENT_FILE));
    } else {
      // send error
      header("HTTP/1.0 404 Not Found", TRUE, 404);      
      return NULL;
    }
    // locate slug
    $entryKey = -1;
    foreach ($data->list as $key => $entry) {            
      if (strcmp($entry->slug, $postTypeEntry->slug)) {        
        // set key
        $entryKey = $key;
      }
    }

    if ($entryKey >= 0) {
      file_put_contents(self::CONTENT_DIRECTORY . "/" . $postTypeEntry->slug . ".json", json_encode($postTypeEntry));
    }    
    // return 200
    header("HTTP/1.0 200 OK", TRUE, 200);
    echo \json_encode($postTypeEntry);
  }

  /**
   * Function which handles DELETE method
   * 
   * @param Object data
   */
  public function deleteput($postTypeEntry) {    
    $postTypeEntry = json_decode($postTypeEntry);   
    // open file with meta data of stored content
    if (file_exists(self::META_CONTENT_FILE)) {
      $data = json_decode(file_get_contents(self::META_CONTENT_FILE));
    } else {
      // send error
      header("HTTP/1.0 404 Not Found", TRUE, 404);      
      return NULL;
    }
    // locate slug
    $entryKey = -1;
    foreach ($data->list as $key => $entry) {            
      if (strcmp($entry->slug, $postTypeEntry->slug)) {        
        // set key
        $entryKey = $key;
      }
    }

    if ($entryKey >= 0) {
    // delete file    
    unlink(self::CONTENT_DIRECTORY . "/" . $postTypeEntry->slug . ".json", json_encode($postTypeEntry));
    // remove meta data with slug    
    array_splice($data->list, $entryKey, 1);
    // return 204
    header("HTTP/1.0 204 Not Content", TRUE, 204);      
    } else {
      // return error
      header("HTTP/1.0 404 Not Found", TRUE, 404);      
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

  // https://stackoverflow.com/questions/14114411/remove-all-special-characters-from-a-string
  function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 }
}