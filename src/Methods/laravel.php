<?php

if (! function_exists('locale')) {
    /**
     * Get the active locale.
     *
     * @return string
     */
    function locale() : string
    {
        return config('app.locale') ?? config('app.fallback_locale');
    }
}
