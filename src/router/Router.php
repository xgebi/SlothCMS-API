<?php
/**
 * Created by PhpStorm.
 * User: tsukasa
 * Date: 2018-12-29
 * Time: 22:57
 */

namespace SlothCMS\Router;

require_once "Route.php";

class Router
{
    private $routes;

    public function __construct()
    {
        $routes = [];
    }

    public function registerRoute($uri, $methods, $controller, $permissions, $isAPI)
    {
        $route = new Route($uri, $methods, $controller, $permissions, $isAPI);
        array_push($this->routes, $route);
    }

    public function run($uri, $method) {
        // @TODO handle permissions here

        foreach ($this->routes as $route) {
            if (preg_match($route->getUri(), $uri)) {
                if ($route->isAPI) {
                    $this->runApiRequest();
                    return;
                } else {
                    $this->runPageRequest();
                    return;
                }
            }
        }
    }
}