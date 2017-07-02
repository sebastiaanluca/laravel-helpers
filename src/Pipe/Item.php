<?php

namespace SebastiaanLuca\Helpers\Pipe;

class Item
{
    /**
     * The current value being handled.
     *
     * @var string
     */
    protected $value;

    /**
     * A unique string that will be replaced with the actual value when calling the pipe method
     * with it.
     *
     * @var string
     */
    protected $identifier = '$$';

    /**
     * Item constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param \Closure|string $callback
     * @param array ...$arguments
     *
     * @return \SebastiaanLuca\Helpers\Pipe\Item $this
     */
    public function pipe($callback, ...$arguments)
    {
        // No explicit use of the value identifier means it should
        // be the first argument to call the method with. If it does
        // get used though, we should replace any occurrence of it
        // with the actual value.
        if (! in_array($this->identifier, $arguments, true)) {
            // Add the given item value as first parameter to call the pipe method with
            array_unshift($arguments, $this->value);
        }
        else {
            $arguments = array_map(function ($argument) {
                return $argument === '$$' ? $this->value : $argument;
            }, $arguments);
        }

        // Call the piped method
        $this->value = $callback(...$arguments);

        // Allow method chaining
        return $this;
    }

    /**
     * Get the current value.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }
}
