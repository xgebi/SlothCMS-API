<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/5/2019
 * Time: 4:01 PM
 */

namespace slothcms\services;


class TemplateService {
    private $template;
    private $args;

    private static $OPENING_TAG = "<#";
    private static $CLOSING_TAG = "#>";

    /**
     * TemplateService constructor.
     * @param $template
     * @param $args
     */
    public function __construct($template, $args = null) {
        $this->template = $template;
        $this->args = $args;
    }

    public function processTemplate() {
        $isFinished = false;
        $openingTagPosition = -1;
        $closingTagPosition = -1;
        while (!$isFinished) {
            $openingTagPosition = strpos($this->template, self::$OPENING_TAG, $closingTagPosition >= 0 ? $closingTagPosition : $openingTagPosition + 1);
            $closingTagPosition = strpos($this->template, self::$CLOSING_TAG, $openingTagPosition >= 0 ? $openingTagPosition : 0);

            if (!$openingTagPosition) {
                break;
            }

            $toeCommand = trim(substr($this->template, $openingTagPosition + 2, $closingTagPosition - ($openingTagPosition + 2)));

            echo $openingTagPosition . " " . $closingTagPosition . " between them is ". $toeCommand ."<br/>";
        }
    }


}