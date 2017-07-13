<?php

namespace core\models;

interface ModelInterface
{

    /**
     * @return string
     */
    public static function getTableName();

    /**
     * @return array|bool
     */
    public static function getAll();

    /**
     * @param $params
     * @return array|bool
     */
    public static function getByParams($params);

    /**
     * @param $id
     * @return array|bool
     */
    public static function getById($id);

    /**
     * @param $params
     * @return bool|\PDOStatement
     */
    public static function deleteByParams($params);

    /**
     * @param $albums
     * @return bool|\PDOStatement
     */
    public static function saveAll($albums);
}