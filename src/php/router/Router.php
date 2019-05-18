<?php
/**
 * Created by PhpStorm.
 * User: tsukasa
 * Date: 2018-12-29
 * Time: 22:57
 */

namespace slothcms\router;

require_once "Route.php";

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function registerRoute($uri, $methods, $controller, $permissions, $isAPI)
    {
        $route = new Route("/sloth-admin".$uri, $methods, $controller, $permissions, $isAPI);
        array_push($this->routes, $route);
    }

    public function run($uri, $method = 'GET') {
        // @TODO handle permissions here

        foreach ($this->routes as $route) {
            if (preg_match("/".preg_quote($route->getUri(), "/") . "/", $uri)) {
                if ($route->isAPI()) {
                    $this->runApiRequest();
                    return;
                } else {
                    $this->runPageRequest($route);
                    return;
                }
            }
        }
    }

    private function runApiRequest() {

    }

    private function runPageRequest($route) {
        $route->getController()->run();
    }
}