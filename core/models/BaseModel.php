<?php


namespace core\models;


use core\Application;

abstract class BaseModel implements ModelInterface
{
    /**
     * Get table name for query
     *
     * @return string table name. As default - class name
     */
    public static function getTableName()
    {
        return strtolower((new \ReflectionClass(static::class))->getShortName());
    }

    /**
     * Get all records
     *
     * @return array|bool
     * @throws \Exception
     */
    public static function getAll()
    {
        return Application::getDb()->select(static::getTableName(), '*');
    }

    /**
     * Get all records by params
     *
     * @param $params
     * @return array|bool
     * @throws \Exception
     */
    public static function getByParams($params)
    {
        return Application::getDb()->select(static::getTableName(), '*', $params);
    }

    /**
     * Get one record by id
     *
     * @param $id
     * @return array|bool
     * @throws \Exception
     */
    public static function getById($id)
    {
        return Application::getDb()->get(static::getTableName(), '*', [
            'id' => $id,
        ]);
    }

    /**
     * Delete records by params
     *
     * @param $params
     * @return bool|\PDOStatement
     * @throws \Exception
     */
    public static function deleteByParams($params)
    {
        return Application::getDb()->delete(static::getTableName(), $params);
    }
}