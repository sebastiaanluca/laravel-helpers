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

if (! function_exists('is_logged_in')) {
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    function is_logged_in() : bool
    {
        return auth()->check();
    }
}
