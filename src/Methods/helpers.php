<?php

if (! function_exists('locale')) {
    /**
     * Get the active locale.
     *
     * @return string
     */
    function locale()
    {
        return config('app.locale', config('app.fallback_locale'));
    }
}

if (! function_exists('carbonize')) {
    /**
     * Create a Carbon object from a string.
     *
     * @param string $timeString
     *
     * @return \Carbon\Carbon
     */
    function carbonize($timeString = null)
    {
        return new \Carbon\Carbon($timeString);
    }
}

if (! function_exists('isActiveRoute')) {
    /**
     * Check if the given route is currently active.
     *
     * @param string $routeName
     * @param string $output
     *
     * @return bool
     */
    function isActiveRoute($routeName, $output = 'active')
    {
        /** @var \Laravelista\Ekko\Ekko $ekko */
        $ekko = app('Laravelista\Ekko\Ekko');
        
        return $ekko->isActiveRoute($routeName, $output);
    }
}

if (! function_exists('take')) {
    /**
     * Create a new piped item from a given value.
     *
     * @param mixed $value
     *
     * @return \SebastiaanLuca\Helpers\Pipe\Item
     */
    function take($value)
    {
        return new \SebastiaanLuca\Helpers\Pipe\Item($value);
    }
}
