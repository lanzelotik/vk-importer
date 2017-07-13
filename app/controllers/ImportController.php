<?php

namespace app\controllers;

use app\models\TaskManager;
use core\controllers\BaseController;

/**
 * Create import albums and photos
 *
 * Class ImportController
 * @package app\controllers
 */
class ImportController extends BaseController
{

    public function run($argv = [])
    {
        echo 'Enter user id: ';

        $userId = trim(fgets(STDIN));

        if (empty($userId) || !is_numeric($userId)) {
            echo 'Wrong user id. Please try again.', PHP_EOL;
        } else {
            TaskManager::set('import', $userId);

            echo 'Import task was created. Please wait and check the result after few minutes.', PHP_EOL;
        }
    }
}