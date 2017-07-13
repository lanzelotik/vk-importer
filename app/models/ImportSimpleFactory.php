<?php

namespace app\models;

class ImportSimpleFactory
{
    public function createApi()
    {
        return new VkApi();
    }
}