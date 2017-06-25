<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Methods;

use Laravelista\Ekko\Ekko;
use SebastiaanLuca\Helpers\Methods\GlobalMethodsServiceProvider;
use SebastiaanLuca\Helpers\Tests\TestCase;

class GlobalMethodsTest extends TestCase
{
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
        return [GlobalMethodsServiceProvider::class];
    }
}
