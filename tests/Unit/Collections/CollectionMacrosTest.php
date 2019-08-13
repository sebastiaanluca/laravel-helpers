<?php

declare(strict_types=1);

namespace SebastiaanLuca\Helpers\Tests\Unit\Collections;

use Carbon\Carbon;
use SebastiaanLuca\Helpers\Collections\CollectionMacrosServiceProvider;
use SebastiaanLuca\Helpers\Tests\TestCase;

class CollectionMacrosTest extends TestCase
{
    /**
     * @test
     */
    public function it creates a collection of carbon instances() : void
    {
        $this->assertEquals(
            collect([
                new Carbon('yesterday'),
                new Carbon('tomorrow'),
                new Carbon('2017-07-01'),
            ]),
            collect([
                'yesterday',
                'tomorrow',
                '2017-07-01',
            ])->carbonize()
        );
    }

    /**
     * @test
     */
    public function it creates a collection of values found between two given values() : void
    {
        $this->assertEquals(
            collect([
                'value1',
                'value2',
                'value3',
            ]),
            collect([
                '"value1"',
                '"value2"',
                '"value3"',
            ])->between('"', '"')
        );
    }

    /**
     * @test
     */
    public function it creates a collection of values found between one given value() : void
    {
        $this->assertEquals(
            collect([
                'value1',
                'value2',
                'value3',
            ]),
            collect([
                '"value1"',
                '"value2"',
                '"value3"',
            ])->between('"')
        );
    }

    /**
     * @test
     */
    public function it transforms keys using a callable() : void
    {
        $this->assertEquals(
            collect([
                'A' => 'value',
                'B' => 'value',
                'C' => 'value',
            ]),
            collect([
                'a' => 'value',
                'b' => 'value',
                'c' => 'value',
            ])->transformKeys('strtoupper')
        );
    }

    /**
     * @test
     */
    public function it transforms keys using a callback() : void
    {
        $this->assertEquals(
            collect([
                'prefix-a' => 'value',
                'prefix-b' => 'value',
                'prefix-c' => 'value',
            ]),
            collect([
                'a' => 'value',
                'b' => 'value',
                'c' => 'value',
            ])->transformKeys(function (string $key) {
                return 'prefix-' . $key;
            })
        );
    }

    /**
     * @test
     */
    public function it transposes a matrix collection() : void
    {
        $this->assertEquals(
            collect([
                [1, 4, 7],
                [2, 5, 8],
                [3, 6, 9],
            ]),
            collect([
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9],
            ])->transpose()
        );
    }

    /**
     * @test
     */
    public function it transposes a matrix collection including keys() : void
    {
        $this->assertEquals(
            collect([
                'id' => [
                    'A' => 1,
                    'B' => 2,
                    'C' => 3,
                ],
                'someName' => [
                    'A' => 'name1',
                    'B' => 'name2',
                    'C' => 'name3',
                ],
            ]),
            collect([
                'A' => [
                    'id' => 1,
                    'name' => 'name1',
                ],
                'B' => [
                    'id' => 2,
                    'name' => 'name2',
                ],
                'C' => [
                    'id' => 3,
                    'name' => 'name3',
                ],
            ])->transposeWithKeys(['id', 'someName'])
        );
    }

    /**
     * @test
     */
    public function it transposes a matrix collection including keys automatically() : void
    {
        $this->assertEquals(
            collect([
                'id' => [
                    'A' => 1,
                    'B' => 2,
                    'C' => 3,
                ],
                'name' => [
                    'A' => 'name1',
                    'B' => 'name2',
                    'C' => 'name3',
                ],
            ]),
            collect([
                'A' => [
                    'id' => 1,
                    'name' => 'name1',
                ],
                'B' => [
                    'id' => 2,
                    'name' => 'name2',
                ],
                'C' => [
                    'id' => 3,
                    'name' => 'name3',
                ],
            ])->transposeWithKeys()
        );
    }

    /**
     * @test
     */
    public function it transposes a matrix collection including keys automatically and handles extra fields() : void
    {
        $this->assertEquals(
            collect([
                'id' => [
                    'A' => 1,
                    'B' => 2,
                    'C' => 3,
                ],
                'name' => [
                    'A' => 'name1',
                    'B' => 'name2',
                    'C' => 'name3',
                ],
                'extra' => [
                    'A' => null,
                    'B' => 'extra2',
                    'C' => null,
                ],
            ]),
            collect([
                'A' => [
                    'id' => 1,
                    'name' => 'name1',
                ],
                'B' => [
                    'id' => 2,
                    'name' => 'name2',
                    'extra' => 'extra2',
                ],
                'C' => [
                    'id' => 3,
                    'name' => 'name3',
                ],
            ])->transposeWithKeys()
        );
    }

    public function test it can transpose an empty collection() : void
    {
        $this->assertEquals(collect(), collect()->transpose());
        $this->assertEquals(collect(), collect()->transposeWithKeys());
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app) : array
    {
        return [
            CollectionMacrosServiceProvider::class,
        ];
    }
}
