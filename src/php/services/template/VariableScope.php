<?php


namespace SlothCMS\php\services\template;


class VariableScope {
    private $id;
    private $parentId;
    private $variableStack = [];

    function __construct($parentId) {
        $this->parentId = $parentId;
        $this->id = uniqid("", true);
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getParentId() {
        return $this->parentId;
    }

    /**
     * @return array
     */
    public function getVariableStack(): array {
        return $this->variableStack;
    }


}