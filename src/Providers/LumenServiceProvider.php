<?php declare(strict_types=1);

namespace Middleware\Auth\Escher\Providers;

/**
 * @property \Laravel\Lumen\Application $app
 */
class LumenServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->configure('escher');
        $this->mergeConfigFrom($this->configPath(), 'escher');
        $this->app->routeMiddleware($this->middlewares);
    }
}
