<?php
namespace SlothAdminApi;

class ConfigHandler {
  protected $filename = "./sloth.conf.json";

  function __construct($uri) {
  }

  public function get() {    

    if (file_exists($this->filename)) {
      header("HTTP/1.0 200 OK", TRUE, 200);
      echo file_get_contents($filename);
    } else {      
        header("HTTP/1.0 404 Not Found", TRUE, 404);
        echo "{ \"notFound\" : true }";
    }
  }

  public function post($data) {    
    if (file_put_contents($this->filename, $data)) {
      header("HTTP/1.0 201 OK", TRUE, 201);
      echo "{ \"configFileCreated\" : true }";
    } else {
      header("HTTP/1.0 500 OK", TRUE, 500);
      echo "{ \"configFileCreated\" : false }";
    }
  }
}