#!/usr/bin/env bash
set -euo pipefail

composer install --no-interaction --prefer-dist --no-progress --no-scripts --optimize-autoloader

if [ -n "${DB_HOST:-}" ] && [ -n "${DB_DATABASE:-}" ]; then
    until php -r "new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" >/dev/null 2>&1; do
        echo "Waiting for MySQL on ${DB_HOST}..."
        sleep 2
    done

    composer run db:fresh
    composer run db:seed
fi

exec php -S 0.0.0.0:8000 -t public
