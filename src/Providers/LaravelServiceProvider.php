<?php declare(strict_types=1);

namespace Middleware\Auth\Escher\Providers;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([realpath($this->configPath()) => config_path('escher.php')]);
        $this->mergeConfigFrom($this->configPath(), 'escher');
        $this->setMiddlewares();
    }

    protected function setMiddlewares(): void
    {
        foreach ($this->middlewares as $alias => $middleware) {
            $this->app['router']->aliasMiddleware($alias, $middleware);
        }
    }
}
