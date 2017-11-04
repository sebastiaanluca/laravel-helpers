<?php

use Carbon\Carbon;
use SebastiaanLuca\Helpers\Classes\MethodHelper;
use SebastiaanLuca\Helpers\Pipe\Item;

if (! function_exists('rand_bool')) {
    /**
     * Randomly return true or false.
     *
     * @return bool
     */
    function rand_bool() : bool
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
    function str_wrap($string, $wrapper) : string
    {
        return $wrapper . $string . $wrapper;
    }
}

if (! function_exists('is_assoc_array')) {
    /**
     * Check if an array is associative.
     *
     * Performs a simple check to determine if the given array's keys are numeric, start at 0,
     * and count up to the amount of values it has.
     *
     * @param array $array
     *
     * @return bool
     */
    function is_assoc_array($array) : bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (! function_exists('array_expand')) {
    /**
     * Expand a flat dotted array to a multi-dimensional associative array.
     *
     * If a key is encountered that is already present and the existing value is an array, each
     * new value will be added to that array. If it's not an array, each new value will override
     * the existing one.
     *
     * @param array $array
     *
     * @return array
     */
    function array_expand(array $array) : array
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
    function array_without(array $array, $values) : array
    {
        return array_values(array_diff($array, array_wrap($values)));
    }
}

if (! function_exists('array_pull_values')) {
    /**
     * Pull an array of values from a given array.
     *
     * Returns the found values that were removed from the source array.
     *
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    function array_pull_values(array &$array, array $values) : array
    {
        $matches = array_values(array_intersect($array, $values));

        $array = array_without($array, $values);

        return $matches;
    }
}

if (! function_exists('array_pull_value')) {
    /**
     * Pull a value from a given array.
     *
     * Returns the given value if it was successfully removed from the source array.
     *
     * @param array $array
     * @param mixed $value
     *
     * @return mixed
     */
    function array_pull_value(array &$array, $value)
    {
        $value = array_pull_values($array, [$value]);

        return array_shift($value);
    }
}

if (! function_exists('array_hash')) {
    /**
     * Create a unique identifier for a given array.
     *
     * @param array $array
     *
     * @return string
     */
    function array_hash(array $array) : string
    {
        return md5(serialize($array));
    }
}

if (! function_exists('object_hash')) {
    /**
     * Create a unique identifier for a given object.
     *
     * @param $object
     *
     * @return string
     */
    function object_hash($object) : string
    {
        return md5(serialize($object));
    }
}

if (! function_exists('has_public_method')) {
    /**
     * Check if a class has a certain public method.
     *
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    function has_public_method($object, $method) : bool
    {
        return MethodHelper::hasPublicMethod($object, $method);
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
    function carbonize($timeString = null) : Carbon
    {
        return new \Carbon\Carbon($timeString);
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
    function take($value) : Item
    {
        return new \SebastiaanLuca\Helpers\Pipe\Item($value);
    }
}

if (! function_exists('create_temporary_file')) {
    /**
     * Create a temporary file.
     *
     * Returns an array with the file handle (resource) and the full path as string.
     *
     * The temporary file is readable and writeable by default. The file is automatically removed when
     * closed (for example, by calling fclose() on the handle, or when there are no remaining references
     * to the file handle), or when the script ends.
     *
     * @return array An array with  a `file` and `path` key.
     */
    function create_temporary_file() : array
    {
        $file = tmpfile();
        $path = stream_get_meta_data($file)['uri'];

        return compact('file', 'path');
    }
}
