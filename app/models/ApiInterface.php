<?php

namespace app\models;

/**
 * Interface ApiInterface
 * @package app\models
 */
interface ApiInterface
{
    /**
     * @param $id
     * @return void
     */
    public function setUserId($id);

    /**
     * @return mixed
     */
    public function getUserData();

    /**
     * @return mixed
     */
    public function getAlbums();

    /**
     * @return mixed
     */
    public function getPhotos($albumId);
}