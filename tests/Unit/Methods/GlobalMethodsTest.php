<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Methods;

use Carbon\Carbon;
use Laravelista\Ekko\Ekko;
use SebastiaanLuca\Helpers\Methods\GlobalHelpersServiceProvider;
use SebastiaanLuca\Helpers\Pipe\Item;
use SebastiaanLuca\Helpers\Tests\TestCase;

class GlobalMethodsTest extends TestCase
{
    public function test it returns a random bool()
    {
        $this->assertInternalType('bool', rand_bool());
    }

    public function test it wraps a string()
    {
        $this->assertSame('wrappermiddlewrapper', str_wrap('middle', 'wrapper'));
    }

    public function test it detects an associative array()
    {
        $this->assertTrue(is_assoc_array([
            'key1' => 'value1',
            'key2' => 'value2',
        ]));

        $this->assertFalse(is_assoc_array(['value1', 'value2']));
    }

    public function test it expands a flat array()
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

    public function test it removes values from an array()
    {
        $this->assertSame(['a', 1], array_without(['a', 'b', 1], 'b'));
        $this->assertSame(['a'], array_without(['a', 'b', 1], ['b', 1]));
    }

    public function test it pulls values from an array()
    {
        $array = ['a', 'b', 'c'];

        $this->assertSame(['b'], array_pull_values($array, ['b']));
        $this->assertSame(['a', 'c'], $array);
    }

    public function test it pulls a value from an array()
    {
        $array = ['a', 'b', 'c'];

        $this->assertSame('b', array_pull_value($array, 'b'));
        $this->assertSame(['a', 'c'], $array);
    }

    public function test it generates an array hash()
    {
        $hash = '9ae1f8db3c2cc8381e0811dda3316176';

        $this->assertSame($hash, array_hash(['value']));
        $this->assertNotSame($hash, array_hash(['value1', 'value2']));
    }

    public function test it generate an object hash()
    {
        $object = new \stdClass;
        $object->property = 'value';

        $hash = '5439deb4526e33a32ffa80a485c623c4';

        $this->assertSame($hash, object_hash($object));

        $object->property2 = 'value2';

        $this->assertNotSame($hash, object_hash($object));
    }

    public function test it creates a carbon instance from a string()
    {
        $this->assertEquals(new Carbon('tomorrow'), carbonize('tomorrow'));
    }

    public function test it creates a pipe item()
    {
        $this->assertInstanceOf(Item::class, take('value'));
    }

    public function test it checks if a public method exists()
    {
        $class = new class
        {
            public function myMethod()
            {
                return true;
            }
        };

        $this->assertTrue(public_method_exists($class, 'myMethod'));
        $this->assertFalse(public_method_exists($class, 'myInvalidMethod'));
    }

    public function test it returns the current locale()
    {
        config(['app.locale' => $locale = 'randomlocale']);

        $this->assertSame($locale, locale());
    }

    public function test it returns the fallback locale if locale not set()
    {
        config(['app.locale' => null]);
        config(['app.fallback_locale' => $locale = 'fallbacklocale']);

        $this->assertSame($locale, locale());
    }

    public function test it checks the active route()
    {
        $ekko = $this->mock(Ekko::class, [app('router'), app('url')]);

        $ekko->shouldReceive('isActiveRoute')->once()->with('home', 'class');

        is_active_route('home', 'class');
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
        return [GlobalHelpersServiceProvider::class];
    }
}
