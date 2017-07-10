<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use SebastiaanLuca\Helpers\Classes\MethodHelper;
use SebastiaanLuca\Helpers\Tests\TestCase;

class MethodHelperTest extends TestCase
{
    public function test it detects if a method of a certain visibility exists()
    {
        $class = new class
        {
            private function myMethod() : bool
            {
                return true;
            }
        };

        $this->assertTrue(MethodHelper::hasMethodOfType($class, 'myMethod', 'private'));
    }

    public function test it detects a missing method()
    {
        $class = new class
        {
            protected function myMethod() : bool
            {
                return true;
            }
        };

        $this->assertFalse(MethodHelper::hasMethodOfType($class, 'myInvalidMethod', 'protected'));
    }

    public function test it detects a method with different visibility()
    {
        $class = new class
        {
            public function myMethod() : bool
            {
                return true;
            }
        };

        $this->assertFalse(MethodHelper::hasMethodOfType($class, 'myMethod', 'private'));
    }

    public function test it detects a protected method()
    {
        $class = new class
        {
            protected function myMethod() : bool
            {
                return true;
            }
        };

        $this->assertTrue(MethodHelper::hasProtectedMethod($class, 'myMethod'));
    }

    public function test it detects a public method()
    {
        $class = new class
        {
            public function myMethod() : bool
            {
                return true;
            }
        };

        $this->assertTrue(MethodHelper::hasPublicMethod($class, 'myMethod'));
    }
}
