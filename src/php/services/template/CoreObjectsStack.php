<?php


namespace slothcms\php\services\template;


class CoreObjectsStack {

    private $toeObjects = [];
    private $slothObjects;

    public function __construct($objectsStack) {
        $this->slothObjects = $objectsStack;
    }

    public function getItem($itemName) {
        if (strpos($itemName, "toe_") === 0) {
            return $this->toeObjects[$itemName];
        } else if (strpos($itemName, "sl_") === 0) {
            return $this->slothObjects[$itemName];
        }
        return null;
    }
}