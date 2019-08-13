<?php

declare(strict_types=1);

namespace SebastiaanLuca\Helpers\Collections;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacrosServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot() : void
    {
        /*
         * Create Carbon instances from items in a collection.
         */

        Collection::macro('carbonize', function () {
            return collect($this->items)->map(function ($time) {
                return new Carbon($time);
            });
        });

        /*
         * Reduce each collection item to the value found between a given start and end string.
         */

        Collection::macro('between', function ($start, $end = null) {
            $end = $end ?? $start;

            return collect($this->items)->reduce(function ($items, $value) use ($start, $end) {
                if (preg_match('/^' . $start . '(.*)' . $end . '$/', $value, $matches)) {
                    $items[] = $matches[1];
                }

                return collect($items);
            });
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
            if ($this->isEmpty()) {
                return $this;
            }

            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());

            return new static($items);
        });

        /*
         * Transpose (flip) a collection matrix (array of arrays) while keeping its columns and row headers intact.
         *
         * Please note that a row missing a column another row does have can only occur for one column. It cannot
         * parse more than one missing column.
         */

        Collection::macro('transposeWithKeys', function (?array $rows = null) {
            if ($this->isEmpty()) {
                return $this;
            }

            if ($rows === null) {
                $rows = $this->values()->reduce(function (array $rows, array $values) {
                    return array_unique(array_merge($rows, array_keys($values)));
                }, []);
            }

            $keys = $this->keys()->toArray();

            // Transpose the matrix
            $items = array_map(function (...$items) use ($keys) {
                // The collection's keys now become column headers
                return array_combine($keys, $items);
            }, ...$this->values());

            // Add the new row headers
            $items = array_combine($rows, $items);

            return new static($items);
        });

        Collection::macro('d', function () {
            d($this);

            return $this;
        });

        Collection::macro('ddd', function () {
            ddd($this);
        });
    }
}
