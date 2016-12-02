<?php

/**
 * ステージング環境用定義
 * SetEnv APPLICATION_ENV "staging"
 */
return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=user_register;host=localhost',
        'username' => 'root',
        'password' => '',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ],
    ],
    'default' => [
        'basename' => 'http://example.staging.zf2',
    ],
];
