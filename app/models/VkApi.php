<?php

namespace app\models;


class VkApi
{
    const URL = 'https://api.vk.com/method/';
    const VERSION = 5.67;

    private $userId;

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserData()
    {
        $result = $this->sendRequest('users.get', [
            'user_ids' => $this->userId,
        ]);

        return $result ? $result[0] : $result;
    }

    public function getAlbums()
    {
        $result = $this->sendRequest('photos.getAlbums', [
            'owner_id' => $this->userId,
        ]);

        return $result ? $result->items : $result;
    }

    public function getPhotos($albumId)
    {
        $result = $this->sendRequest('photos.get', [
            'album_id' => $albumId,
            'owner_id' => $this->userId,
        ]);

        if ($result) {
            $result = $result->items;
            foreach($result as $photo) {
                $photo->link = self::getBiggestPhoto($photo);
            }
        }

        return $result;
    }

    private function sendRequest($method, $params)
    {
        $requestParams = array_merge([
                'v' => self::VERSION,
            ],
            $params
        );

        $getParams = http_build_query($requestParams);
        $result = json_decode(file_get_contents(self::URL . $method . '?' . $getParams));

        usleep(500);

        if ($result->response) {
            return $result->response;
        } else {
            return null;
        }
    }

    public static function getSizeVariants()
    {
        return [
            'photo_2560',
            'photo_1280',
            'photo_807',
            'photo_604',
            'photo_130',
            'photo_75',
        ];
    }

    public static function getBiggestPhoto($photo)
    {
        $sizeVariants = self::getSizeVariants();
        foreach ($sizeVariants as $key => $size) {
            if (isset($photo->$size)) {
                return $photo->$size;
            }
        }

        return $photo->{end($sizeVariants)};
    }
}