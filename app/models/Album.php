<?php

namespace app\models;

use core\Application;
use core\models\BaseModel;

/**
 * Class Album
 * @package app\models
 */
class Album extends BaseModel
{

    /**
     * @param $albums
     * @return bool|\PDOStatement
     * @throws \Exception
     */
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

        return Application::getDb()->insert(self::getTableName(), $data);
    }
}