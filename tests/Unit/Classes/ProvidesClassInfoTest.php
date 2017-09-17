<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use ReflectionClass;
use SebastiaanLuca\Helpers\Classes\ProvidesClassInfo;
use SebastiaanLuca\Helpers\Tests\TestCase;

class ProvidesClassInfoTest extends TestCase
{
    /**
     * @test
     */
    function it returns the class directory()
    {
        $class = new class
        {
            use ProvidesClassInfo;

            public function getDirectory()
            {
                return $this->getClassDirectory();
            }
        };

        $this->assertSame(dirname((new ReflectionClass($this))->getFileName()), $class->getDirectory());
    }
}
