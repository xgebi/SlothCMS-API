<?php

namespace SlothCMS\php\services\template;


class VariableScope {
    private $id;
    private $parentScope;
    private $variableStack = [];

    function __construct($parentScope) {
        $this->parentScope = $parentScope;
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
    public function getParentScope() {
        return $this->parentScope;
    }

    /**
     * @return array
     */
    public function getVariableStack(): array {
        return $this->variableStack;
    }


}
