<?php

namespace SebastiaanLuca\Helpers\Modules;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider
{
    /**
     * The (preferably lowercase) module name to use when publishing packages or loading resources.
     *
     * @var string
     */
    protected $module = '';

    /**
     * @var \Nwidart\Modules\Module
     */
    protected $instance;

    /**
     * Register the application services.
     */
    public function register()
    {
        if (! app()->environment('production')) {
            $this->registerEloquentFactoriesFrom($this->getModulePath() . '/database/factories');
        }

        $this->registerConfiguration();
        $this->bindRepositories();
        $this->registerCommands();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootResources();
        $this->registerPublishableResources();
        $this->mapMorphTypes();
        $this->bootMiddleware(app(Kernel::class), app('router'));
        $this->mapRoutes();
        $this->registerListeners();
    }

    /**
     * Register an additional directory of factories.
     *
     * @param string $path
     */
    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(Factory::class)->load($path);
    }

    /**
     * Get the root path of the module.
     *
     * @return string
     */
    protected function getModulePath()
    {
        if (! $this->instance) {
            $this->instance = app('modules')->findOrFail($this->module);
        }

        return $this->instance->getPath();
    }

    /**
     * Automatically register and merge all configuration files found in the package with the ones
     * published by the user.
     */
    protected function registerConfiguration()
    {
        $configuration = $this->getModulePath() . '/config/config.php';

        if (! file_exists($configuration)) {
            return;
        }

        $this->mergeConfigFrom($configuration, str_replace('/', '.', $this->module));
    }

    /**
     * Bind concrete repositories to their interfaces.
     */
    protected function bindRepositories()
    {
        //
    }

    /**
     * Register artisan commands.
     */
    protected function registerCommands()
    {
        //
    }

    /**
     * Prepare all module assets.
     */
    protected function bootResources()
    {
        $this->loadMigrationsFrom($this->getModulePath() . '/database/migrations');
        $this->loadViewsFrom($this->getModulePath() . '/resources/views', $this->module);
        $this->loadTranslationsFrom($this->getModulePath() . '/resources/lang', $this->module);
    }

    /**
     * Register all publishable module assets.
     */
    protected function registerPublishableResources()
    {
        $this->publishes([
            $this->getModulePath() . '/config' => config_path($this->module)
        ], 'config');
    }

    /**
     * Map class morph types.
     */
    protected function mapMorphTypes()
    {
        //
    }

    /**
     * Register package middleware.
     *
     * @param Kernel $kernel
     * @param \Illuminate\Routing\Router $router
     */
    protected function bootMiddleware(Kernel $kernel, Router $router)
    {
        //
    }

    /**
     * Map out all module routes.
     */
    protected function mapRoutes()
    {
        //
    }

    /**
     * Listen to events.
     */
    protected function registerListeners()
    {
        //
    }
}
