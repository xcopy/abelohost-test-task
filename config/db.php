<?php

declare(strict_types=1);

return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'port' => getenv('DB_PORT') ?: '3306',
    'dbname' => getenv('DB_DATABASE') ?: 'abelohost',
    'user' => getenv('DB_USERNAME') ?: 'abelohost',
    'password' => getenv('DB_PASSWORD') ?: 'abelohost',
    'charset'  => 'utf8mb4',
];
