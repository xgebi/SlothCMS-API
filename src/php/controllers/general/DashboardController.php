<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 1/6/2019
 * Time: 9:17 PM
 */

namespace slothcms\controllers\general;

require_once __DIR__ . "/../ControllerInterface.php";
require_once __DIR__ . "/../../services/TemplateService.php";

use slothcms\controllers\ControllerInterface;
use slothcms\services\TemplateService;

class DashboardController implements ControllerInterface {
    public function run() {
        $template = file_get_contents(__DIR__ . "/../../views/dashboard.html");
        $templateService = new TemplateService($template);
        $templateService->processTemplate();
    }

    public function runApi() {
        header("HTTP/1.0 501 Not Implemented");
        exit;
    }

}