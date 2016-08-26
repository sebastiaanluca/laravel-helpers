<?php

namespace SebastiaanLuca\Helpers\Collections;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionHelperServiceProvider extends ServiceProvider
{
    /**
     * Boot all collection macros.
     */
    protected function bootMacros()
    {
        // Create Carbon instances from items in a collection
        Collection::macro('carbonize', function () {
            return collect($this->items)->map(function ($time) {
                if (empty($time)) {
                    return null;
                }
                
                return new Carbon($time);
            });
        });
    }
    
    /**
     * Register the service provider.
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
        $this->bootMacros();
    }
}