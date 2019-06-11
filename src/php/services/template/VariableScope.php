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

    public function setVariable($variableName, $variableValue) {
        $this->variableStack[$variableName] = $variableValue;
    }

    public function isVariableInCurrentScope($variableName) {
        return array_key_exists($variableName, $this->variableStack);
    }

    public function isVariableInParentsScopes($variableName) {
        // TODO review this in the morning, it's highly likely that my logic is deeply flawed
        if (!$this->isVariableInCurrentScope($variableName)) {
            if ($this->parentScope) {
                if (!array_key_exists($variableName, $this->parentScope->getVariableStack($variableName))) {
                    return $this->parentScope->isVariableInParentsScopes($variableName);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return $this->variableStack[$variableName];
        }
    }

    public function getVariable($variableName) {

    }


}
