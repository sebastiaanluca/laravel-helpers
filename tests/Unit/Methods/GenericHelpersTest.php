<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Methods;

use Carbon\Carbon;
use SebastiaanLuca\Helpers\Methods\GlobalHelpersServiceProvider;
use SebastiaanLuca\Helpers\Pipe\Item;
use SebastiaanLuca\Helpers\Tests\TestCase;

class GenericHelpersTest extends TestCase
{
    /**
     * @test
     */
    function rand_bool returns a random bool()
    {
        $this->assertInternalType('bool', rand_bool());
    }

    /**
     * @test
     */
    function str_wrap wraps a string()
    {
        $this->assertSame('wrappermiddlewrapper', str_wrap('middle', 'wrapper'));
    }

    /**
     * @test
     */
    function is_assoc_array detects an associative array()
    {
        $this->assertTrue(is_assoc_array([
            'key1' => 'value1',
            'key2' => 'value2',
        ]));

        $this->assertFalse(is_assoc_array(['value1', 'value2']));
    }

    /**
     * @test
     */
    function array_expand expands a flat array()
    {
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1,
                ],
                'd' => 2,
            ],
            'e' => 3,
        ], array_expand([
            'a.b.c' => 1,
            'a.d' => 2,
            'e' => 3,
        ]));
    }

    /**
     * @test
     */
    function array_without removes values from an array()
    {
        $this->assertSame(['a', 1], array_without(['a', 'b', 1], 'b'));
        $this->assertSame(['a'], array_without(['a', 'b', 1], ['b', 1]));
    }

    /**
     * @test
     */
    function array_pull_values pulls values from an array()
    {
        $array = ['a', 'b', 'c'];

        $this->assertSame(['b'], array_pull_values($array, ['b']));
        $this->assertSame(['a', 'c'], $array);
    }

    /**
     * @test
     */
    function array_pull_value pulls a value from an array()
    {
        $array = ['a', 'b', 'c'];

        $this->assertSame('b', array_pull_value($array, 'b'));
        $this->assertSame(['a', 'c'], $array);
    }

    /**
     * @test
     */
    function array_hash generates an array hash()
    {
        $hash = '9ae1f8db3c2cc8381e0811dda3316176';

        $this->assertSame($hash, array_hash(['value']));
        $this->assertNotSame($hash, array_hash(['value1', 'value2']));
    }

    /**
     * @test
     */
    function object_hash generate an object hash()
    {
        $object = new \stdClass;
        $object->property = 'value';

        $hash = '5439deb4526e33a32ffa80a485c623c4';

        $this->assertSame($hash, object_hash($object));

        $object->property2 = 'value2';

        $this->assertNotSame($hash, object_hash($object));
    }

    /**
     * @test
     */
    function carbonize creates a carbon instance from a string()
    {
        $this->assertEquals(new Carbon('tomorrow'), carbonize('tomorrow'));
    }

    /**
     * @test
     */
    function take creates a pipe item()
    {
        $this->assertInstanceOf(Item::class, take('value'));
    }

    /**
     * @test
     */
    function has_public_method checks if a public method exists()
    {
        $class = new class
        {
            /**
             * @test
             */
            function myMethod()
            {
                return true;
            }
        };

        $this->assertTrue(has_public_method($class, 'myMethod'));
        $this->assertFalse(has_public_method($class, 'myInvalidMethod'));
    }

    /**
     * @test
     */
    public function create_temporary_file creates a temporary file and returns its pointer and full path()
    {
        $file = create_temporary_file();

        dd($file);

        $this->assertArrayHasKey('file', $file);
        $this->assertArrayHasKey('path', $file);

        $this->assertInternalType('resource', $file['file']);

        $this->assertInternalType('string', $file['path']);
        $this->assertFileExists($file['path']);
    }

    /**
     * @test
     */
    public function the file created by create_temporary_file is automatically deleted when it goes out of scope()
    {
        $file = create_temporary_file();

        $path = $file['path'];

        unset($file);

        $this->assertFileNotExists($path);
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GlobalHelpersServiceProvider::class,
        ];
    }
}
