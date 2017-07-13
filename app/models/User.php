<?php
namespace app\models;

use core\Application;
use core\models\BaseModel;

class User extends BaseModel
{
    public static function saveAll($users)
    {
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];
        }

        Application::getDb()->insert(self::getTableName(), $data);
    }
}