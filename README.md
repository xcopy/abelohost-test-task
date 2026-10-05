A lightweight PHP application for browsing blog categories and posts using a simple MVC structure, FastRoute routing, and Smarty for views.

## Features

- Category listing and detail pages
- Post detail pages
- Lightweight routing with `nikic/fast-route`
- Template rendering with Smarty
- Database migrations and seed support via Phinx

## Tech Stack

- PHP
- Composer
- MySQL
- Smarty
- SASS

## Requirements

- PHP 8.1+
- Composer
- MySQL 8.4+

## Setup

Install PHP dependencies:

```bash
composer install
```

Copy the environment file and adjust database settings if needed:

```bash
cp .env.dist .env
```

Optional: update the database values in `.env` as required for your local environment.

Create the database referenced by your configuration.

Example:

```bash
create user if not exists 'abelohost'@'localhost' identified by 'abelohost';
create database if not exists abelohost character set utf8mb4 collate utf8mb4_unicode_ci;
grant all privileges on abelohost.* to 'abelohost'@'localhost';
flush privileges;
```

Run database migrations:

```bash
composer run db:fresh
```

Run seeds:

```bash
composer run db:seed
```

## Running the App

Serve the `public/` directory with PHP's built-in server:

```bash
php -S localhost:8000 -t public
```

Then open http://localhost:8000
