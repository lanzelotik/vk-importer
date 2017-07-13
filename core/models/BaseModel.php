<?php


namespace core\models;


use core\Application;

abstract class BaseModel implements ModelInterface
{
    public static function getTableName()
    {
        return strtolower((new \ReflectionClass(static::class))->getShortName());
    }

    public static function getAll()
    {
        return Application::getDb()->select(static::getTableName(), '*');
    }

    public static function getByParams($params)
    {
        return Application::getDb()->select(static::getTableName(), '*', $params);
    }

    public static function getById($id)
    {
        return Application::getDb()->get(static::getTableName(), '*', [
            'id' => $id,
        ]);
    }

    public static function deleteByParams($params)
    {
        return Application::getDb()->delete(static::getTableName(), $params);
    }
}