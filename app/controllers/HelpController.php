<?php

namespace app\controllers;

use core\controllers\BaseController;

/**
 * Out help info
 *
 * Class HelpController
 * @package app\controllers
 */
class HelpController extends BaseController
{

    public function run($argv = [])
    {
        $commands = $this->getCommands();

        echo "Available commands: \n\n";
        foreach ($commands as $command => $description) {
            echo $command, "\t\t", $description, "\n";
        }
    }

    /**
     * Returns all available command names.
     * @return array all available command names
     */
    public function getCommands()
    {
        $controllerPath = $this->getControllerPath();

        if (is_dir($controllerPath)) {
            $files = scandir($controllerPath);
            $suffixLength = strlen($this->suffix);
            foreach ($files as $file) {
                if (!empty($file) && substr_compare($file, $this->suffix, -$suffixLength, $suffixLength) === 0) {
                    $name = substr(basename($file), 0, -$suffixLength);
                    $alias = strtolower(trim(preg_replace('/[A-Z]/', $this->separator . '\0', $name), $this->separator));
                    $commands[$alias] = $this->getDescription($file);
                }
            }
        }

        ksort($commands);
        return $commands;
    }
}