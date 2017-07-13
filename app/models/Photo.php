<?php

namespace app\models;

use core\Application;
use core\models\BaseModel;

class Photo extends BaseModel
{
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

        Application::getDb()->insert(self::getTableName(), $data);
    }
}