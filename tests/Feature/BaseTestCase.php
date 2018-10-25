<?php

namespace Middleware\Auth\Escher\Tests\Feature;

use Illuminate\Routing\Router;
use Middleware\Auth\Escher\Http\Middlewares\EscherAuthMiddleware;
use Middleware\Auth\Escher\Providers\LaravelServiceProvider;

abstract class BaseTestCase extends \Orchestra\Testbench\TestCase
{
    use \Illuminate\Foundation\Validation\ValidatesRequests;

    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']['escher'] = [
            'credentialScope' => 'eu/packaging/ems_request',
            'keyDB' => '{"testKey": "testSecret"}',
            'hashAlgo' => 'SHA256',
            'algoPrefix' => 'EMS',
            'vendorKey' => 'EMS',
            'authHeaderKey' => 'X-Ems-Auth',
            'dateHeaderKey' => 'X-Ems-Date',
            'clockSkew' => 300,
        ];
    }

    protected function getPackageProviders($app): array
    {
        return [LaravelServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $router = $app['router'];
        $this->addRoutes($router);
    }

    protected function addRoutes(Router $router): void
    {
        $router->get('api/unprotected', [
            'as' => 'api.unprotected',
            'uses' => static function () {
                return 'pong';
            }
        ]);

        $router->group(['middleware' => EscherAuthMiddleware::class], static function () use ($router) {
            $router->get('api/protected', [
                'as' => 'api.protected',
                'uses' => static function () {
                    return 'pong';
                }
            ]);
        });
    }
}
