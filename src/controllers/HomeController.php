<?php
/**
 * Created by PhpStorm.
 * User: tsukasa
 * Date: 2018-12-29
 * Time: 23:31
 */

namespace slothcms\controllers;

require_once __DIR__."/../services/TemplateService.php";

use slothcms\services\TemplateService;

class HomeController
{
    public function run($args = null) {
        $templateService = new TemplateService(file_get_contents(__DIR__ . "/../views/home.html"));
        print($templateService->processTemplate());
    }
}