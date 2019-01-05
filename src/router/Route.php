<?php
/**
 * Created by PhpStorm.
 * User: tsukasa
 * Date: 2018-12-29
 * Time: 22:57
 */

namespace slothcms\router;


class Route
{
    /* URI, methods, controller, permissions level and API/web page boolean */

    private $controller;
    private $uri;
    private $methods;
    private $permissions;
    private $isAPI;

    public function __construct($uri, $methods, $controller, $permissions = 0, $isAPI = false)
    {
        $this->uri = $uri;
        $this->methods = $methods;
        $this->controller = $controller;
        $this->permissions = $permissions;
        $this->isAPI = $isAPI;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @return int
     */
    public function getPermissions(): int
    {
        return $this->permissions;
    }

    /**
     * @return bool
     */
    public function isAPI(): bool
    {
        return $this->isAPI;
    }


}