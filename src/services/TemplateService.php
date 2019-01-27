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

    private $variableStack = [];

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

            if (is_int(strpos($toeCommand, ToeSymbols::Assign)) && strpos($toeCommand, ToeSymbols::Assign) == 0) {
                $this->processVariableAssignment($toeCommand, $openingTagPosition, $closingTagPosition);
                continue;
            }

            if (is_int(strpos($toeCommand, ToeSymbols::Print)) && strpos($toeCommand, ToeSymbols::Print) == 0) {
                $this->processPrintCommand($toeCommand, $openingTagPosition, $closingTagPosition);
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

    private function processVariableAssignment($toeCommand, $start, $end) {
        $cmdParameterArray = explode(" ",  $toeCommand);

        if (is_int(strpos($cmdParameterArray[2], '"'))) {
            $temp = implode(" ", array_slice($cmdParameterArray, 2));
            array_splice($cmdParameterArray, 2);
            $cmdParameterArray[2] = substr($temp, 1, strlen($temp) > strrpos($temp, '"') ? strlen($temp) - 2 : strrpos($temp, '"') - 1);
        }

        $this->variableStack[$cmdParameterArray[1]] = $cmdParameterArray[2];
        $this->template = substr_replace($this->template, "", $start, ($end + 2) - $start);
    }

    private function processPrintCommand($toeCommand, $start, $end) {
        $cmdParameterArray = explode(" ",  $toeCommand);
        //print_r($cmdParameterArray);
        if (is_int(strpos($cmdParameterArray[1], '"'))) {
            $temp = implode(" ", array_slice($cmdParameterArray, 2));
            array_splice($cmdParameterArray, 2);
            $cmdParameterArray[1] = substr($temp, 1, strlen($temp) > strrpos($temp, '"') ? strlen($temp) - 2 : strrpos($temp, '"') - 1);
        }
      //  print_r($cmdParameterArray);
        if (is_numeric($cmdParameterArray[1])) {
            $this->template = substr_replace($this->template, $cmdParameterArray[1], $start, ($end + 2) - $start);
            return;
        }
    //    echo "a";
        if (is_string($cmdParameterArray[1]) && is_int(strpos($cmdParameterArray, '"')) && strpos($cmdParameterArray, '"') == 0) {
            $this->template = substr_replace($this->template, $cmdParameterArray[1], $start, ($end + 2) - $start);
            return;
        }
  //      echo "b";
        if (array_key_exists($cmdParameterArray[1], $this->variableStack)) {
            $this->template = substr_replace($this->template, $this->variableStack[$cmdParameterArray[1]], $start, ($end + 2) - $start);
            return;
        }
//        echo "c";
        $this->template = substr_replace($this->template, "", $start, ($end + 2) - $start);


    }


}