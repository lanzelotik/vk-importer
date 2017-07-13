<?php

namespace app\models;

use core\Application;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class TaskManager
{

    private $_connection;
    private $_channel;

    private static $_instance;

    public static function set($queue, $data)
    {
        $taskManager = self::getInstance();
        $taskManager->getChanel()->queue_declare($queue, false, false, false, false);

        $msg = new AMQPMessage($data);
        $taskManager->getChanel()->basic_publish($msg, '', $queue);

        $taskManager->getChanel()->close();
        $taskManager->getConnection()->close();
    }

    public static function run($queue, $callback)
    {
        $taskManager = self::getInstance();
        $taskManager->getChanel()->queue_declare($queue, false, false, false, false);
        $taskManager->getChanel()->basic_consume($queue, '', false, true, false, false, $callback);

        while (count($taskManager->getChanel()->callbacks)) {
            $taskManager->getChanel()->wait();
        }
        $taskManager->getChanel()->close();
        $taskManager->getConnection()->close();
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection()
    {
        return $this->_connection;
    }

    public function getChanel()
    {
        return $this->_channel;
    }

    private function __construct()
    {
        $config = Application::getConfig()['taskManager'];
        $this->_connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['pass']
        );
        $this->_channel = $this->getConnection()->channel();
    }

    private function __clone()
    {
    }
}