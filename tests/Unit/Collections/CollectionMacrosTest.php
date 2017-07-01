<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Collections;

use Carbon\Carbon;
use SebastiaanLuca\Helpers\Collections\CollectionMacrosServiceProvider;
use SebastiaanLuca\Helpers\Tests\TestCase;

class CollectionMacrosTest extends TestCase
{
    public function test it creates a collection of carbon instances()
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

    public function test it creates a collection of values found between two given values()
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
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [CollectionMacrosServiceProvider::class];
    }
}
