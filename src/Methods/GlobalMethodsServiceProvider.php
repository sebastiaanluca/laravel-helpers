<?php

namespace SebastiaanLuca\Helpers\Methods;

use Illuminate\Support\ServiceProvider;

class GlobalMethodsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/helpers.php';
    }
}