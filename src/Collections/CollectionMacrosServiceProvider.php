<?php

namespace SebastiaanLuca\Helpers\Collections;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
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

        // TODO: remove? Fixed in L5.4.x?
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

        /*
         * Transpose (flip) a collection matrix (array of arrays).
         *
         * @see https://adamwathan.me/2016/04/06/cleaning-up-form-input-with-transpose/
         */
        Collection::macro('transpose', function () {
            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());

            return new static($items);
        });

        /*
         * Transpose (flip) a collection matrix (array of arrays) while keeping
         * its columns and row headers intact.
         */
        Collection::macro('transposeWithKeys', function (array $rows) {
            $keys = $this->keys()->toArray();

            // Transpose the matrix
            $items = array_map(function (...$items) use ($keys) {
                // The collection's keys now become column headers
                return array_combine($keys, $items);
            }, ...$this->values());

            // Add the row headers
            $items = array_combine($rows, $items);

            return new static($items);
        });
    }
}
