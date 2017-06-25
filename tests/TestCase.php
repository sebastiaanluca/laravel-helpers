<?php

namespace SebastiaanLuca\Helpers\Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Mock a class and bind it in the IoC container.
     *
     * @param string $class
     * @param mixed $parameters
     *
     * @return \Mockery\MockInterface|$class
     */
    protected function mock($class, $parameters = []) : MockInterface
    {
        $mock = Mockery::mock($class, $parameters);

        $this->app->instance($class, $mock);

        return $mock;
    }
}
