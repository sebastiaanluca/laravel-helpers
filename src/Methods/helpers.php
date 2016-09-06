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

if (! function_exists('rand_bool')) {
    /**
     * Randomly return true or false.
     *
     * @return bool
     */
    function rand_bool()
    {
        return rand(0, 1) === 0;
    }
}

if (! function_exists('str_wrap')) {
    /**
     * Wrap a string with another string.
     *
     * @param string $string
     * @param string $wrapper
     *
     * @return string
     */
    function str_wrap($string, $wrapper)
    {
        return $wrapper . $string . $wrapper;
    }
}
