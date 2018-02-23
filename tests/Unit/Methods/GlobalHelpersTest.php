<?php

namespace SebastiaanLuca\Helpers\Tests\Unit\Methods;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use SebastiaanLuca\Helpers\Methods\GlobalHelpersServiceProvider;
use SebastiaanLuca\Helpers\Tests\TestCase;

class GlobalHelpersTest extends TestCase
{
    /**
     * @test
     */
    function locale returns the current locale()
    {
        config(['app.locale' => $locale = 'randomlocale']);

        $this->assertSame($locale, locale());
    }

    /**
     * @test
     */
    function locale returns the fallback locale if locale not set()
    {
        config(['app.locale' => null]);
        config(['app.fallback_locale' => $locale = 'fallbacklocale']);

        $this->assertSame($locale, locale());
    }

    /**
     * @test
     */
    public function is_guest returns true if the current user is a guest()
    {
        $this->assertTrue(is_guest());
    }

    /**
     * @test
     */
    public function is_guest returns false if the current user is not a guest()
    {
        $this->be(new User);

        $this->assertFalse(is_guest());
    }

    /**
     * @test
     */
    public function is_logged_in returns false if the current user is not logged in()
    {
        $this->assertFalse(is_logged_in());
    }

    /**
     * @test
     */
    public function is_logged_in returns true if the current user is logged in()
    {
        $this->be(new User);

        $this->assertTrue(is_logged_in());
    }

    /**
     * @test
     */
    public function user returns null if the current user is not logged in()
    {
        $this->assertNull(user());
    }

    /**
     * @test
     */
    public function user returns the user object if the current user is logged in()
    {
        $this->be(new User);

        $this->assertInstanceOf(
            Authenticatable::class,
            user()
        );
    }

    /**
     * @test
     */
    public function me returns null if the current user is not logged in()
    {
        $this->assertNull(me());
    }

    /**
     * @test
     */
    public function me returns the user object if the current user is logged in()
    {
        $this->be(new User);

        $this->assertInstanceOf(
            Authenticatable::class,
            me()
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
        return [
            GlobalHelpersServiceProvider::class,
        ];
    }
}
