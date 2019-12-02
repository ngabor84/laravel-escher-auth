<?php declare(strict_types=1);

namespace Middleware\Auth\Escher\Providers;

use Escher\Escher;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Middleware\Auth\Escher\Http\Middlewares\EscherAuthMiddleware;

abstract class ServiceProvider extends BaseServiceProvider
{
    protected $middlewares = [
        'escher.auth' => EscherAuthMiddleware::class,
    ];

    abstract public function boot(): void;

    public function register(): void
    {
        $this->app->singleton(Escher::class, static function ($app) {
            $config = $app['config']->get('escher');

            $escher = Escher::create($config['credentialScope']);
            $escher->setClockSkew($config['clockSkew']);
            $escher->setHashAlgo($config['hashAlgo']);
            $escher->setAlgoPrefix($config['algoPrefix']);
            $escher->setAuthHeaderKey($config['authHeaderKey']);
            $escher->setDateHeaderKey($config['dateHeaderKey']);
            $escher->setVendorKey($config['vendorKey']);

            return $escher;
        });
    }

    protected function configPath(): string
    {
        return dirname(__DIR__, 2) . '/config/escher.php';
    }
}
