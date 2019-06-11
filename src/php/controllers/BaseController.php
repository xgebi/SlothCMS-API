<?php


namespace slothcms\controllers;

use slothcms\services\TemplateService;

require_once __DIR__ . "/ControllerInterface.php";
require_once __DIR__ . "/../services/auth/AuthService.php";
require_once __DIR__ . "/../services/template/TemplateService.php";

class BaseController implements ControllerInterface {
    private $pageSettings = [
        "sl_page_name" => "base",
        "sl_page_display_name" => "Base page"
    ];

    public function run() {
        $template = file_get_contents(__DIR__ . "/../../views/login.html");
        $templateService = new TemplateService(__DIR__ . "/../../views/", $template, $this->pageSettings);
        print($templateService->processTemplate());
    }

    public function runApi() {
        header("HTTP/1.0 501 Not Implemented");
        exit;
    }


}