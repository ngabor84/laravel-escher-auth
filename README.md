[ ![Codeship Status for ngabor84/laravel-escher-auth](https://app.codeship.com/projects/dc3aadc0-b8f0-0136-f2db-52c8808a0161/status?branch=master)](https://app.codeship.com/projects/312071)

# Escher Auth Middleware
Escher authentication middleware for the Laravel and Lumen framework.

## About
This package allows you to authenticate the incoming requests with Escher authentication.

## Installation
Require the ngabor84/laravel-escher-auth package in your composer.json and update your dependencies:
```bash
composer require ngabor84/laravel-escher-auth
```

## Usage with Laravel
Add the service provider to the providers array in the config/app.php config file as follows:
```php
'providers' => [
    ...
    ngabor84\Middleware\Auth\Escher\Providers\LaravelServiceProvider::class,
]
```
Run the following command to publish the package config file:

```bash
php artisan vendor:publish --provider="ngabor84\Middleware\Auth\Escher\Providers\LaravelServiceProvider"
```
You should now have a config/escher.php file that allows you to configure the basics of this package.

## Usage with Lumen
Add the following snippet to the bootstrap/app.php file under the providers section as follows:
```php
// Uncomment this line
$app->register(App\Providers\AuthServiceProvider::class);

// Add this line
$app->register(ngabor84\Middleware\Auth\Escher\Providers\LaravelServiceProvider::class);
```
