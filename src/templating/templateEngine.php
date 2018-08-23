<?php
/**
 * Template handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Templating;


/**
 * @package SlothAdminApi\Templating
 */
class TemplateEngine {

  private $entries;
  
  function __construct($entries, $themePath) {
    // 1. loop through entries
    foreach ($variable as $key => $value) {
      // a. in each entry loop through languages
        // I. locate proper template for a post type
          // i. when template is missing use index.toe
        // II. in each language generate an html file
      // b. store post type, tags and categories
    }
    // 2. regenerate home page
      // a. in each entry loop through languages
    // 3. if post type has archive
      // a. in each entry loop through languages
        // I. regenerate archive
    // 4. if post type has categories
      // a. in each entry loop through languages
        // I. regenerate categories
    // 5. if post type has tags
      // a. in each entry loop through languages
        // I. regenerate tags
  }
  
}