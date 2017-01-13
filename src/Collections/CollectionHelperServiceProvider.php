<?php

namespace SebastiaanLuca\Helpers\Collections;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionHelperServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->bootMacros();
    }

    /**
     * Boot all collection macros.
     */
    protected function bootMacros()
    {
        // Create Carbon instances from items in a collection
        Collection::macro('carbonize', function () {
            return collect($this->items)->map(function ($time) {
                if (empty($time)) {
                    return null;
                }

                return new Carbon($time);
            });
        });

        // Reduce the collection to only include strings found between another start and end string
        Collection::macro('between', function ($start, $end) {
            return collect($this->items)->reduce(function ($items, $method) use ($start, $end) {
                if (preg_match('/^' . $start . '(.*)' . $end . '$/', $method, $matches)) {
                    $items[] = $matches[1];
                }

                return collect($items);
            });
        });

        // Return
        Collection::macro('methodize', function ($method) {
            return collect($this->items)->map(function ($item) use ($method) {
                return call_user_func($method, $item);
            });
        });

        // Fixed in Laravel 5.4
        Collection::macro('mapWithIntegerKeys', function ($callback) {
            $result = [];

            foreach ($this->items as $key => $value) {
                $assoc = $callback($value, $key);

                foreach ($assoc as $mapKey => $mapValue) {
                    $result[$mapKey] = $mapValue;
                }
            }

            return new static($result);
        });

        Collection::macro('d', function () {
            d($this);

            return $this;
        });

        Collection::macro('ddd', function () {
            ddd($this);
        });

        /*
         * Perform an operation on the collection's keys.
         */
        Collection::macro('transformKeys', function (callable $operation) {
            return collect($this->items)->mapWithKeys(function ($item, $key) use ($operation) {
                return [$operation($key) => $item];
            });
        });
    }
}
