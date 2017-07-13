<?php

namespace core\controllers;

use core\Component;

/**
 * Class BaseController
 * @package core\controllers
 */
abstract class BaseController extends Component
{
    /**
     * @param array $argv
     * @return void
     */
    abstract function run($argv = []);
}