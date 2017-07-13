<?php

namespace core;

use core\controllers\BaseController;
use Medoo\Medoo;

class Application extends Component
{
    private static $config;
    private static $db;

    public static function getConfig()
    {
        return static::$config;
    }

    public function __construct($config)
    {
        static::$config = $config;
    }

    /**
     * @return Medoo
     * @throws \Exception
     */
    public static function getDb()
    {
        if (!self::$db) {
            $dbConf = self::getConfig()['database'];
            if (empty($dbConf)) {
                throw new \Exception('DB conf is empty');
            }
            static::$db = new Medoo($dbConf);
        }
        return self::$db;
    }

    public function run($argv = [])
    {
        $command = empty($argv[1]) ? 'help' : $argv[1];
        $command = str_replace(' ', '', ucwords(implode(' ', explode('-', $command))));
        $className = $this->getClassPath($command);

        /** @var BaseController $controller */
        $controller = new $className;
        $controller->run($argv);
    }
}