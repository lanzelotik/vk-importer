<?php

namespace app\models;

/**
 * Class ImportSimpleFactory
 * @package app\models
 */
class ImportSimpleFactory
{
    /**
     * @return ApiInterface
     */
    public function createApi()
    {
        return new VkApi();
    }
}