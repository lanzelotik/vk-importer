<?php

namespace app\models;

use core\Application;
use core\models\BaseModel;

/**
 * Class Photo
 * @package app\models
 */
class Photo extends BaseModel
{
    /**
     * @param $photos
     * @return bool|\PDOStatement
     * @throws \Exception
     */
    public static function saveAll($photos)
    {
        $data = [];
        foreach ($photos as $photo) {
            $data[] = [
                'id' => $photo->id,
                'album_id' => $photo->album_id,
                'owner_id' => $photo->owner_id,
                'text' => $photo->text,
                'date' => $photo->date,
                'link' => $photo->link,
            ];
        }

        return Application::getDb()->insert(self::getTableName(), $data);
    }
}