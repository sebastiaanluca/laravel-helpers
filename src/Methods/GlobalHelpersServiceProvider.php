<?php

namespace SebastiaanLuca\Helpers\Methods;

use Illuminate\Support\ServiceProvider;

class GlobalHelpersServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        require_once __DIR__ . '/helpers.php';
    }
}
