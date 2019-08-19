<?php

return [
    'build_active'  =>  true,
    'company_id_code' => 'user()->com_id',
    'user_id_code'  =>  'user()->id',
    'copy_to'   =>  '/../zenwel-api',
    'database' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'laravelrestbuilder',
            'username' => 'root',
            'password' => '',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ],
];