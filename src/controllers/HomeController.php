<?php
/**
 * Created by PhpStorm.
 * User: tsukasa
 * Date: 2018-12-29
 * Time: 23:31
 */

namespace slothcms\controllers;


class HomeController
{
    public function run($args = null) {
        readfile(__DIR__ . "/../views/home.html");
    }
}