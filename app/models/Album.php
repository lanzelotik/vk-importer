<?php

namespace app\models;


use core\Application;
use core\models\BaseModel;

class Album extends BaseModel
{
    public static function saveAll($albums)
    {
        $data = [];
        foreach ($albums as $album) {
            $data[] = [
                'id' => $album->id,
                'owner_id' => $album->owner_id,
                'title' => $album->title,
                'description' => $album->description,
                'created' => $album->created,
                'updated' => $album->updated,
                'size' => $album->size,
            ];
        }

        Application::getDb()->insert(self::getTableName(), $data);
    }
}