<?php

declare(strict_types=1);

$config = require __DIR__ . '/config/db.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $config['host'],
            'port' => $config['port'],
            'name' => $config['dbname'],
            'user' => $config['user'],
            'pass' => $config['password'],
            'charset' => $config['charset'],
        ],
    ],
    'version_order' => 'creation'
];
