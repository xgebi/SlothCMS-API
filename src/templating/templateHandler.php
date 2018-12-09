<?php
/**
 * Template handler
 * 
 * @author Sarah Gebauer
 * @version 0.0.1
 */
namespace SlothAdminApi\Templating;

/**
 * Helpers object
 */
require_once(__DIR__ . '/../helpers.php');


/**
 * @package SlothAdminApi\Templating
 */
class TemplateHandler extends \SlothAdminApi\Helpers {
  private $mainConfigFile = __DIR__ . "/../../../sloth.conf.json";
  private $templatesFolder = __DIR__ . "/../../../sloth-themes";

  private $entries;
  
  function __construct($entries) {
    // 1. get current theme name from configuration
    $config = json_decode(\file_get_contents($this->mainConfigFile));
    $name = "";
    if ($config->name) {
      $name = $config->name;
    }

    if (\strlen($name) == 0) {
      parent::sendResponse(500, "Internal Server Error");
      return;
    }
    // 2. get list of folders in sloth-themes
    $list = scandir($this->templatesFolder);
    // 3. for through the list
    $path = "";
    foreach ($list as $key => $value) {
      if (is_dir($this->templatesFolder . "/" . $value)) {
        // a. check for info.json file
        if (is_file($this->templatesFolder . "/" . $value . "/info.json")) {
        // b. if it exists open info.json file
          $themeInfoJson = json_decode(file_get_contents($this->templatesFolder . "/" . $value . "/info.json"));
          // I. if name doesn't exist report theme as broken
          if (!$themeInfoJson->name) {
            parent::sendResponse(500, "Internal Server Error");
            return;
          }
          // II. if name is the same return the path to that theme
          if (strcasecmp($themeInfoJson->name, $config->name)) {
            $path = $this->templatesFolder . "/" . $value;
            break;
          }
          // III. if name is not the same continue
        } else {
          parent::sendResponse(500, "Internal Server Error");
          return;
        }
      }
    }      

    // 4. if there's not a path to the theme, throw an error
    if (strlen($path) == 0) {
      parent::sendResponse(500, "Internal Server Error");
      return;
    }

    // 5. Start TemplateEngine 
    $templateEngine = new \SlothAdminApi\Templating\TemplateEngine($entries, $path, $mainLanguage);

  }
  
}