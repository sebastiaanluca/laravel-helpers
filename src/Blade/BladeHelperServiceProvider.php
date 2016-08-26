<?php

namespace SebastiaanLuca\Helpers\Blade;

use Illuminate\Support\ServiceProvider;

class BladeHelperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade = $this->app['blade.compiler'];
    }
}