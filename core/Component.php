<?php

namespace core;


abstract class Component
{
    public $separator = '-';
    public $controllerNamespace = 'app\controllers';

    protected function getControllerPath()
    {
        return __DIR__ . '/../' . str_replace('\\', '/', $this->controllerNamespace);
    }

    protected function getDescription($file)
    {
        $controllerClass = $this->controllerNamespace . '\\' . substr(basename($file), 0, -4);

        $reflection = new \ReflectionClass($controllerClass);
        $docLines = preg_split('~\R~u', $reflection->getDocComment());
        if (isset($docLines[1])) {
            return trim($docLines[1], "\t *");
        }
        return '';

    }

    protected function getClassPath($className)
    {
        return $this->controllerNamespace . '\\' . $className . 'Controller';
    }
}