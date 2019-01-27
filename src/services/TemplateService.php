<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/5/2019
 * Time: 4:01 PM
 */

namespace slothcms\services;

require_once "ToeSymbols.php";

class TemplateService {
    private $template;
    private $args;

    private static $OPENING_TAG = "<#";
    private static $CLOSING_TAG = "#>";

    private $openingTagPosition = -1;
    private $closingTagPosition = -1;

    /**
     * TemplateService constructor.
     * @param $template
     * @param $args
     */
    public function __construct($template, $args = null) {
        $this->template = $template;
        $this->args = $args;
    }

    public function processTemplate($openingTagPosition = -1 ,$closingTagPosition = -1) {
        $isFinished = false;
        $index = 0;
        while (!$isFinished) {
            $toeCommand = "";
            $openingTagPosition = strpos($this->template, self::$OPENING_TAG, $openingTagPosition + 1);
            if (!is_int($openingTagPosition)) {
                break;
            }
            $closingTagPosition = strpos($this->template, self::$CLOSING_TAG, $openingTagPosition);



            $toeCommand = trim(substr($this->template, $openingTagPosition + 2, $closingTagPosition - ($openingTagPosition + 2)));

            if (strlen($toeCommand) == 0) {
                continue;
            }

            if (is_int(strpos($toeCommand, ToeSymbols::Import)) && strpos($toeCommand, ToeSymbols::Import) == 0) {
                $this->processImportStatement($toeCommand, $openingTagPosition, $closingTagPosition);
                continue;
            }

        }

        return $this->template;
    }

    private function processImportStatement($toeCommand, $start, $end) {
        $cmdParameterArray = explode(" ", $toeCommand);
        if (count($cmdParameterArray) == 2 && file_exists(__DIR__ . "/../views/" . $cmdParameterArray[1] . ".html")) {
            $imported = file_get_contents(__DIR__ . "/../views/" . $cmdParameterArray[1] . ".html");
            $this->template = substr_replace($this->template, $imported, $start, ($end + 2) - $start);
        } else {
            $this->template = substr_replace($this->template, "", $start, ($end + 2) - $start);
        }
    }


}