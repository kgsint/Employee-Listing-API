# Employee Management API with Laravel

## Features 
- Token-based authentication with Laravel Passport
- Middleware
- Validation
- CRUD with API

## Installation and Setup 
install required dependencies

```bash
composer install
```

copy `.env.example` file to `.env` :
```
cp .env.example .env
```
Generate `APP_KEY`
```bash
php artisan key:generate
```
run migrations:
```bash
php artisan migrate
```

to generate secure access tokens with Passport:
```bash
php artisan passport:install
```

Start development server
```
php artisan serve
```
