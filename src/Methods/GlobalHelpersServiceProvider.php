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
        require_once __DIR__ . '/generic.php';
        require_once __DIR__ . '/framework.php';
        require_once __DIR__ . '/debug.php';
    }
}
