<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Classes;

use SebastiaanLuca\Helpers\Pipe\Item;
use SebastiaanLuca\Helpers\Tests\TestCase;

class PipeTest extends TestCase
{
    /**
     * @test
     */
    function it can transform a value using a callable string method()
    {
        $this->assertSame(
            'STRING',
            (new Item('string'))->pipe('strtoupper')->get()
        );
    }

    /**
     * @test
     */
    function it can transform a value using a closure()
    {
        $this->assertSame(
            'prefixed-string',
            (new Item('string'))->pipe(function (string $value) {
                return 'prefixed-' . $value;
            })->get()
        );
    }

    /**
     * @test
     */
    function it can transform a value while accepting pipe parameters()
    {
        $this->assertSame(
            'value',
            (new Item(['key' => 'value']))->pipe('array_get', 'key')->get()
        );
    }

    /**
     * @test
     */
    function it can transform a complex value in multiple steps()
    {
        $this->assertSame(
            'blog',
            (new Item('https://blog.sebastiaanluca.com'))
                ->pipe('parse_url')
                ->pipe('array_get', 'host')
                ->pipe('explode', '.', '$$')
                ->pipe('array_get', 0)
                ->get()
        );
    }

    /**
     * @test
     */
    function it returns an item object when get has not been called yet()
    {
        $this->assertInstanceOf(Item::class, (new Item('string'))->pipe('strtoupper'));
    }

    public function test it uses the identifier to replace the actual value()
    {
        $this->assertSame(
            'The meaning of everything is to make everything be more.',
            (new ExtendedItem('The meaning of life is to make life be more.'))
                ->pipe('str_replace', 'life', 'everything', '42')
                ->get()
        );
    }
}

class ExtendedItem extends Item
{
    protected $identifier = '42';
}
