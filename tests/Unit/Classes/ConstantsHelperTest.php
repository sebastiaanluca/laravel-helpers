<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use SebastiaanLuca\Helpers\Classes\Constants;
use SebastiaanLuca\Helpers\Tests\TestCase;

class ConstantsHelperTest extends TestCase
{
    public function test it returns all constants()
    {
        $class = new class
        {
            use Constants;

            const FIRST_CONSTANT = 1;
            const SECOND_CONSTANT = 2;
            const THIRD_CONSTANT = 3;
        };

        $this->assertEquals([
            "FIRST_CONSTANT" => 1,
            "SECOND_CONSTANT" => 2,
            "THIRD_CONSTANT" => 3,
        ], $class::getConstants());
    }

    public function test it returns all constants through the shorthand method()
    {
        $class = new class
        {
            use Constants;

            const FIRST_CONSTANT = 1;
            const SECOND_CONSTANT = 2;
            const THIRD_CONSTANT = 3;
        };

        $this->assertEquals([
            "FIRST_CONSTANT" => 1,
            "SECOND_CONSTANT" => 2,
            "THIRD_CONSTANT" => 3,
        ], $class::constants());
    }
}
