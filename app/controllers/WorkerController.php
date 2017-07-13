<?php

namespace app\controllers;

use app\models\User;
use app\models\Album;
use app\models\Photo;
use app\models\ImportSimpleFactory;
use app\models\TaskManager;
use \core\controllers\BaseController;


/**
 * Import data via API
 *
 * Class WorkerController
 * @package app\controllers
 */
class WorkerController extends BaseController
{
    public function run($arv = [])
    {
        echo ' Waiting for user id. To exit press CTRL+C', PHP_EOL;

        TaskManager::run('import', function ($msg) {
            $userId = $msg->body;
            echo ' - received user id ', $userId, PHP_EOL;

            Photo::deleteByParams(['owner_id' => $userId]);
            Album::deleteByParams(['owner_id' => $userId]);
            User::deleteByParams(['id' => $userId]);

            $factory = new ImportSimpleFactory();
            $api = $factory->createApi();
            $api->setUserId($userId);

            $albums = $api->getAlbums();
            if (!empty($albums)) {
                $user = $api->getUserData();
                User::saveAll([$user]);
                Album::saveAll($albums);
            } else {
                echo ' - albums not exists for user id ', $userId, PHP_EOL;
                return false;
            }

            foreach ($albums as $album) {
                $photos = $api->getPhotos($album->id);
                Photo::saveAll($photos);
            }

            echo ' - complete for user id ', $userId, PHP_EOL;

            return true;

        });
    }
}