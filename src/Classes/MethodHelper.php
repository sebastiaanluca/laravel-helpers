<?php

namespace SebastiaanLuca\Helpers\Classes;

use Error;
use ReflectionException;
use ReflectionMethod;

class MethodHelper
{
    /**
     * Check if an object has a given method of a given type.
     *
     * @param object $object
     * @param string $method
     * @param string $type
     *
     * @return bool
     */
    public static function hasMethodOfType($object, $method, $type)
    {
        if (! method_exists($object, $method)) {
            return false;
        }

        try {
            $reflection = new ReflectionMethod($object, $method);
            $type = 'is' . studly_case($type);

            return $reflection->{$type}();
        } catch (ReflectionException $exception) {
            return false;
        } catch (Error $exception) {
            return false;
        }
    }

    /**
     * Check if an object has a given protected method.
     *
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    public static function hasProtectedMethod($object, $method)
    {
        return static::hasMethodOfType($object, $method, 'protected');
    }

    /**
     * Check if an object has a given public method.
     *
     * @param object $object
     * @param string $method
     *
     * @return bool
     */
    public static function hasPublicMethod($object, $method)
    {
        return static::hasMethodOfType($object, $method, 'public');
    }
}
