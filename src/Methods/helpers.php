<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;

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

if (! function_exists('is_guest')) {
    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    function is_guest() : bool
    {
        return auth()->guest();
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

if (! function_exists('user')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user() : ?Authenticatable
    {
        return auth()->user();
    }
}

if (! function_exists('me')) {
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function me() : ?Authenticatable
    {
        return auth()->user();
    }
}
