<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Methods;

use Illuminate\Foundation\Auth\User;
use SebastiaanLuca\Helpers\Methods\GlobalHelpersServiceProvider;
use SebastiaanLuca\Helpers\Tests\TestCase;

class LaravelHelpersTest extends TestCase
{
    /**
     * @test
     */
    function it returns the current locale()
    {
        config(['app.locale' => $locale = 'randomlocale']);

        $this->assertSame($locale, locale());
    }

    /**
     * @test
     */
    function it returns the fallback locale if locale not set()
    {
        config(['app.locale' => null]);
        config(['app.fallback_locale' => $locale = 'fallbacklocale']);

        $this->assertSame($locale, locale());
    }

    /**
     * @test
     */
    public function it returns false if a user is not logged in()
    {
        $this->assertFalse(is_logged_in());
    }

    /**
     * @test
     */
    public function it returns true if a user is logged in()
    {
        $this->be(new User);

        $this->assertTrue(is_logged_in());
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
