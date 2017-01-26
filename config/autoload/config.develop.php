<?php

/**
 * 開発環境用定義
 * SetEnv APPLICATION_ENV "develop"
 */
use Zend\Log\Logger;

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=user_register;host=localhost',
        'username' => 'root',
        'password' => '',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_PERSISTENT => true,
        ],
    ],
    'log' => [
        'Log\App' => [
            'writers' => [
                [
                    'name' => 'stream',
                    'options' => [
                        'stream' => '/tmp/logs/application.log',
                        'filters' => [
                            'priority' => [
                                'name' => 'priority',
                                'options' => [
                                    'priority' => Logger::DEBUG,
                                ],
                            ],
                        ],
                        'formatter' => [
                            'name' => 'simple',
                            'options' => [
                                'format' => '%timestamp% [%priorityName%] %message%',
                                'dateTimeFormat' => 'Y-m-d H:i:s',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
