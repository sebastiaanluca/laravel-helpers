<?php

namespace SebastiaanLuca\Helpers\Classes;

use ReflectionClass;

trait ConstantTrait
{
    /**
     * Get all the class' constants.
     *
     * @return array
     */
    protected static function getConstants() : array
    {
        return (new ReflectionClass(__CLASS__))->getConstants();
    }
}
