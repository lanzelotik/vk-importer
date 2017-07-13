<?php

namespace core\controllers;

use core\Component;

abstract class BaseController extends Component
{
    abstract function run($argv = []);
}