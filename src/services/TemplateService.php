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

    /**
     * TemplateService constructor.
     * @param $template
     */
    public function __construct($template) {
        $this->template = $template;
    }


}