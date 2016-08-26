<?php

namespace SebastiaanLuca\Helpers\Html;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function ($app) {
            $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->getToken());
            
            return $form->setSessionStore($app['session.store']);
        });
        
        $this->app->alias('form', FormBuilder::class);
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFormBuilder();
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['form', FormBuilder::class];
    }
}