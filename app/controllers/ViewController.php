<?php

namespace app\controllers;

use app\models\Album;
use app\models\Photo;
use \core\controllers\BaseController;
use app\models\User;

/**
 * View stored information
 *
 * Class ViewController
 * @package app\controllers
 */
class ViewController extends BaseController
{
    public function run($argv = [])
    {
        $userId = $this->getUser();
        $albumId = $this->getAlbum($userId);
        $this->getPhotos($albumId);
    }

    protected function getUser()
    {
        $users = User::getAll();
        if (empty($users)) {
            echo ' There is no users in database', PHP_EOL;
            exit(1);
        }
        echo ' Select user from: ', PHP_EOL;
        foreach ($users as $key => $user) {
            printf(" [%d] %s %s \n", $key, $user['first_name'], $user['last_name']);
        }

        echo PHP_EOL, ' Your choice [0-' . (count($users) - 1) . ', or "q" to quit] ';
        $num = trim(fgets(STDIN));

        if (!ctype_digit($num) || !isset($users[$num])) {
            echo "\n Quit.\n";
            exit(0);
        }

        return $users[$num]['id'];
    }

    protected function getAlbum($userId)
    {
        $albums = Album::getByParams(['owner_id' => $userId]);
        if (empty($albums)) {
            echo ' User doesn\'t have any albums', PHP_EOL;
            exit(2);
        }

        echo ' Select album from: ', PHP_EOL;
        foreach ($albums as $key => $album) {
            printf(" [%d] %s (%d photos)\n", $key, $album['title'], $album['size']);
        }
        echo PHP_EOL, ' Your choice [0-' . (count($albums) - 1) . ', or "q" to quit] ';
        $num = trim(fgets(STDIN));

        if (!ctype_digit($num) || !isset($albums[$num])) {
            echo "\n Quit.\n";
            exit(0);
        }

        return $albums[$num]['id'];
    }

    protected function getPhotos($albumId)
    {
        $photos = Photo::getByParams(['album_id' => $albumId]);
        if (empty($photos)) {
            echo PHP_EOL, ' Album is empty', PHP_EOL;
            exit(3);
        }
        echo " Photo ID \tPhoto URL", PHP_EOL;
        foreach ($photos as $photo) {
            printf(" %d \t%s \n", $photo['id'], $photo['link']);
        }
    }
}