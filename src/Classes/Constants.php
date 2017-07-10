<?php

namespace SebastiaanLuca\Helpers\Classes;

use ReflectionClass;

trait Constants
{
    /**
     * Get all the class' constants.
     *
     * @return array
     */
    public static function getConstants() : array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }

    /**
     * Shorthand helper to get all the class' constants.
     *
     * @return array
     */
    public static function constants() : array
    {
        return static::getConstants();
    }
}
