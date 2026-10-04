FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts --optimize-autoloader \
    && chmod +x /var/www/html/docker/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html

EXPOSE 8000

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
