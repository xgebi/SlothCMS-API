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
    public function __construct($template, $args) {
        $this->template = $template;

        $this->processTemplate($template);
    }

    private function processTemplate($template) {
        $openingTagPosition = -1;
        while (($openingTagPosition = strpos($template, self::$OPENING_TAG)) > 0) {
            $closingTagPosition = strpos($template, self::$CLOSING_TAG, $openingTagPosition);
        }
    }


}