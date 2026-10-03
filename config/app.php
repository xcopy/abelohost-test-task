<?php

declare(strict_types=1);

return [
    'env' => getenv('APP_ENV') ?: 'production',
    'renderer' => getenv('APP_RENDERER') ?: 'smarty',
];
