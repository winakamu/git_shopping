<?php

return array(
    'default' => array(
        'type' => 'pdo',

        'connection' => array(
            'dsn'        => 'mysql:host=mysql;port=3306;dbname=shopping',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => false,
        ),

        'identifier'   => '`',
        'table_prefix' => '',
        'charset'      => 'utf8mb4',
        'enable_cache' => true,
        'profiling'    => true,
    ),

    // mongoDBの設定追加
    'mongo' => array(
        'default' => array(
            'hostname' => 'shopping-mongo',
            'port'     => 27017,
            'database' => 'shopping',
        ),
    ),
);