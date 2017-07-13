<?php

namespace app\models;

use core\Application;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class TaskManager
 * @package app\models
 */
class TaskManager
{

    private $_connection;
    private $_channel;

    private static $_instance;

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

    /**
     * @return TaskManager
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @param $queue
     * @param $data
     */
    public static function set($queue, $data)
    {
        $taskManager = self::getInstance();
        $taskManager->getChanel()->queue_declare($queue, false, false, false, false);

        $msg = new AMQPMessage($data);
        $taskManager->getChanel()->basic_publish($msg, '', $queue);

        $taskManager->getChanel()->close();
        $taskManager->getConnection()->close();
    }

    /**
     * @param $queue
     * @param $callback
     */
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

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChanel()
    {
        return $this->_channel;
    }
}