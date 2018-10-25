[ ![Codeship Status for ngabor84/laravel-escher-auth](https://app.codeship.com/projects/dc3aadc0-b8f0-0136-f2db-52c8808a0161/status?branch=master)](https://app.codeship.com/projects/312071)
[![GitHub license](https://img.shields.io/github/license/ngabor84/laravel-escher-auth.svg)](https://github.com/ngabor84/laravel-escher-auth/blob/master/LICENSE)

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
    \Middleware\Auth\Escher\Providers\LaravelServiceProvider::class,
]
```
Run the following command to publish the package config file:
```bash
php artisan vendor:publish --provider="Middleware\Auth\Escher\Providers\LaravelServiceProvider"
```
You should now have a config/escher.php file that allows you to configure the basics of this package.

## Usage with Lumen
Add the following snippet to the bootstrap/app.php file under the providers section as follows:
```php
$app->register(\Middleware\Auth\Escher\Providers\LumenServiceProvider::class);
...
$app->configure('escher');
```

Create a config directory (if it's not exist), and create an escher.php in it with the plugin configuration like this:
```php
return [
    'hashAlgo' => 'SHA256',
    'algoPrefix' => 'EMS',
    'vendorKey' => 'EMS',
    'authHeaderKey' => 'X-EMS-Auth',
    'dateHeaderKey' => 'X-EMS-Date',
    'clockSkew' => '300',
    'credentialScope' => env('ESCHER_CREDENTIAL_SCOPE'),
    'keyDB' => env('ESCHER_KEY_DB'),
];
```
