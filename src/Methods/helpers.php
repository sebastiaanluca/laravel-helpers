<?php

use SebastiaanLuca\Helpers\Classes\MethodHelper;

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

if (! function_exists('is_assoc_array')) {
    /**
     * Check if an array is associative.
     *
     * @param array $array
     *
     * @return bool
     */
    function is_assoc_array($array)
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (! function_exists('public_method_exists')) {
    /**
     * Check if an object has a given public method.
     *
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    function public_method_exists($object, $method)
    {
        return MethodHelper::hasPublicMethod($object, $method);
    }
}

if (! function_exists('array_expand')) {
    /**
     * Expand a flat dotted array to a multi-dimensional associative array.
     *
     * @param array $array
     *
     * @return array
     */
    function array_expand(array $array)
    {
        $expanded = [];

        foreach ($array as $key => $value) {
            array_set($expanded, $key, $value);
        }

        return $expanded;
    }
}

if (! function_exists('array_without')) {
    /**
     * Get the array without the given values.
     *
     * @param array $array
     * @param array|string $values
     *
     * @return array
     */
    function array_without(array $array, $values)
    {
        if (! is_array($values)) {
            $values = [$values];
        }

        return array_values(array_diff($array, $values));
    }
}

if (! function_exists('ddd_if')) {
    /**
     * Only debugs a statement given a truth condition.
     *
     * @param mixed $condition
     * @param array ...$args
     */
    function ddd_if($condition, ...$args)
    {
        if (! $condition) {
            return;
        }

        ddd(...$args);
    }
}
