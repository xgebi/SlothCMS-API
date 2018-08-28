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
    $themeInfo = json_decode(file_get_contents($themePath . "info.json"));

    // 1. loop through entries
    foreach ($entries as $entry) {
      // a. locate proper template for a post type
        $templateToUse = "";
        foreach ($themeInfo->templates->specialTemplates as $postType) {
          if ($postType->postTypeName == $entry->postType) {
            $templateToUse = $postType->template;
            break;
          }
        }
        // I. when template is missing use index.toe
        if (strlen($templateToUse) == 0) {
          $templateToUse = "index.toe";
        }
      // b. in each language generate an html file
      foreach ($entry->languages as $language) {
        

        // I. store post type, tags and categories per language
        
      }
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