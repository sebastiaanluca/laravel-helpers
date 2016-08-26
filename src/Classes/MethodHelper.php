<?php

namespace SebastiaanLuca\Helpers\Classes;

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
    public static function hasMethod($object, $method, $type)
    {
        // Primary check
        if (! method_exists($object, $method)) {
            return false;
        }
        
        // Accessibility check
        try {
            $reflection = new ReflectionMethod($object, $method);
            $type = 'is' . studly_case($type);
            
            return $reflection->{$type}();
        } catch (ReflectionException $exception) {
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
        return self::hasMethod($object, $method, 'protected');
    }
}