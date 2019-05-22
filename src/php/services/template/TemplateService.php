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
    private $templateUri;

    private static $OPENING_TAG = "<#";
    private static $CLOSING_TAG = "#>";

    private $variableStack = [];

    /**
     * TemplateService constructor.
     * @param $template
     * @param $args
     */
    public function __construct($templateUri, $template, $args = null) {
        $this->template = $template;
        $this->args = $args;
        $this->templateUri = $templateUri;
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

            if (is_int(strpos($toeCommand, ToeSymbols::If)) && strpos($toeCommand, ToeSymbols::If) == 0) {
                $this->processIfKeyword($toeCommand, $openingTagPosition, $closingTagPosition);
                continue;
            }

        }

        return $this->template;
    }

    private function processImportStatement($toeCommand, $start, $end) {
        $cmdParameterArray = explode(" ", $toeCommand);
        if (count($cmdParameterArray) == 2 && file_exists($this->templateUri . $cmdParameterArray[1] . ".html")) {
            $imported = file_get_contents($this->templateUri . $cmdParameterArray[1] . ".html");
            $this->template = substr_replace($this->template, $imported, $start, ($end + 2) - $start);
        } else {
            $this->template = substr_replace($this->template, "", $start, ($end + 2) - $start);
        }
    }

    private function processVariableAssignment($toeCommand, $start, $end) {
        $cmdParameterArray = explode(" ",  $toeCommand);
        if (is_numeric($cmdParameterArray[1])) {
            //exit();
        }

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
        if (is_int(strpos($cmdParameterArray[1], '"'))) {
            $temp = implode(" ", array_slice($cmdParameterArray, 2));
            array_splice($cmdParameterArray, 2);
            $cmdParameterArray[1] = substr($cmdParameterArray[1], 1) . " " . substr($temp, 0, strlen($temp) - 1);
            $this->template = substr_replace($this->template, $cmdParameterArray[1], $start, ($end + 2) - $start);
            return;
        }
        if (is_numeric($cmdParameterArray[1])) {
            $this->template = substr_replace($this->template, $cmdParameterArray[1], $start, ($end + 2) - $start);
            return;
        }
        if (is_string($cmdParameterArray[1]) && is_int(strpos($cmdParameterArray[1], '"')) && strpos($cmdParameterArray, '"') == 0) {
            $this->template = substr_replace($this->template, $cmdParameterArray[1], $start, ($end + 2) - $start);
            return;
        }


        if (array_key_exists($cmdParameterArray[1], $this->variableStack)) {
            $this->template = substr_replace($this->template, $this->variableStack[$cmdParameterArray[1]], $start, ($end + 2) - $start);
            return;
        }
        $this->template = substr_replace($this->template, "", $start, ($end + 2) - $start);


    }

    private function processIfKeyword($toeCommand, $start, $end) {
        if (substr_count($toeCommand, "(") != substr_count($toeCommand, ")")) {
            return;
        }
        if ($this->deconstructExpression($toeCommand)) {
            if ($possibleEndif = strpos($this->template, "<# endif", $end)) {
                $levels = substr_count($this->template, "<# if", $end, $possibleEndif - $end);
                if ($levels == 0) {
                    $endIfPos = strpos($this->template, "#>", $possibleEndif) + 2;
                    $this->template = substr_replace($this->template, "", $possibleEndif, ($endIfPos + 2) - $possibleEndif );

                    $this->template = substr_replace($this->template, "", $start,  ($end + 2) - $start);
                } else {
                    $lastEndIfOccurrence = strpos($this->template, "<# endif", $end);

                    while (true) {

                        if (substr_count($this->template, "<# if", $end, $lastEndIfOccurrence - $end) ==
                            substr_count($this->template, "<# endif", $end, $lastEndIfOccurrence - $end)) {
                            $endIfPos = strpos($this->template, "#>", $lastEndIfOccurrence) + 2;
                            $this->template = substr_replace($this->template, "", $lastEndIfOccurrence, ($endIfPos + 2) - $lastEndIfOccurrence );

                            $this->template = substr_replace($this->template, "", $start,  ($end + 2) - $start);
                            break;
                        } else {
                            $lastEndIfOccurrence = strpos($this->template, "<# endif", $lastEndIfOccurrence + 1);
                        }
                    }
                }
            }
        } else {
            if ($possibleEndif = strpos($this->template, "<# endif", $end)) {
                if (substr_count($this->template, "<# if", $end, $possibleEndif - $end) == 0) {
                    $endIfPos = strpos($this->template, "#>", $possibleEndif) + 2;
                    $this->template = substr_replace($this->template, "", $start,  ($endIfPos + 2) - $start);
                }
            }
        }

    }

    private function deconstructExpression($expression) {
        $level = 0;
        $currentIndex = 0;
        $expressions = [];
        $comparators = [];
        $result = false;
        $expression = trim($expression);
        $expression = substr($expression, stripos($expression, "(") + 1, strripos($expression, ")") - (stripos($expression, "(")  + 1));
        for ($i = 0; $i < strlen($expression); $i++) {
            if ($expression[$i] == "(") {
                $level++;
                continue;
            }
            if ($expression[$i] == ")") {
                $level--;
                continue;
            }
            if ($level == 0) {
                switch ($expression[$i]) {
                    case '|':
                    case '&':
                        $expressions[] = trim(substr($expression, $currentIndex, $i - $currentIndex));
                        $currentIndex = $i;
                        if ($expression[$i + 1] == "|" ||
                            $expression[$i + 1] == "&") {
                            $comparators[] = trim(substr($expression, $currentIndex, 2));
                            $currentIndex += 2;
                        } else {
                            $comparators[] = trim(substr($expression, $currentIndex, 1));
                            $currentIndex++;
                        }
                        $i = $currentIndex - 1;
                }
            }
        }
        $expressions[] = trim(substr($expression, $currentIndex));

        if (count($comparators)== 0 && count($expressions) == 1) {
            return $this->evaluateExpression($expressions[0]);
        } else {
            for ($j = 0; $j < count($expressions); $j++) {
                if ($j == 0) {
                    $result = $this->evaluateExpression($expressions[0]);
                } else {
                    if (strcmp($comparators[$j - 1], "&&")) {
                        $result &= $expressions[$j];
                    }

                    if (strcmp($comparators[$j - 1], "||")) {
                        $result |= $expressions[$j];
                    }
                }
            }
            return $result;
        }
    }

    private function evaluateExpression($expression) {
        if (strpos($expression, ToeSymbols::Equals)) {
            $exploded = explode(ToeSymbols::Equals, $expression);
            if ($this->variableStack[trim($exploded[0])] == trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] == trim($exploded[0])) {
                return true;
            }
            return false;
        }
        if (strpos($expression, ToeSymbols::IsNot)) {
            $exploded = explode(ToeSymbols::IsNot, $expression);
            if ($this->variableStack[trim($exploded[0])] == trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] == trim($exploded[0])) {
                return false;
            }
            return true;
        }

        if (strpos($expression, ToeSymbols::GreaterEqualThan)) {
            $exploded = explode(ToeSymbols::GreaterEqualThan, $expression);
            if ($this->variableStack[trim($exploded[0])] >= trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] >= trim($exploded[0])) {
                return true;
            }
            return false;
        }
        if (strpos($expression, ToeSymbols::LessEqualThan)) {
            $exploded = explode(ToeSymbols::LessEqualThan, $expression);
            if ($this->variableStack[trim($exploded[0])] <= trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] <= trim($exploded[0])) {
                return true;
            }
            return false;
        }
        if (strpos($expression, ToeSymbols::GreaterThan)) {
            $exploded = explode(ToeSymbols::GreaterThan, $expression);
            if ($this->variableStack[trim($exploded[0])] > trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] > trim($exploded[0])) {
                return true;
            }
            return false;
        }
        if (strpos($expression, ToeSymbols::LessThan)) {
            $exploded = explode(ToeSymbols::LessThan, $expression);
            if ($this->variableStack[trim($exploded[0])] < trim($exploded[1]) ||
                $this->variableStack[trim($exploded[1])] < trim($exploded[0])) {
                return true;
            }
            return false;
        }
    }

}