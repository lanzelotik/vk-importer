<?php
namespace app\models;

use core\Application;
use core\models\BaseModel;

/**
 * Class User
 * @package app\models
 */
class User extends BaseModel
{
    /**
     * @param $users
     * @return bool|\PDOStatement
     * @throws \Exception
     */
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

        return Application::getDb()->insert(self::getTableName(), $data);
    }
}