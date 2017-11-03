<?php

if (class_exists(Kint::class) && ! function_exists('sss')) {
    /**
     * Display structured debug information about one or more values in plain text using Kint
     * and halt script execution afterwards. Accepts multiple arguments to dump.
     *
     * @param array ...$args
     */
    function sss(...$args)
    {
        s(...$args);

        die;
    }

    // See https://kint-php.github.io/kint/advanced/#plugins
    Kint::$aliases[] = 'sss';
}

if (class_exists(Kint::class) && ! function_exists('ddd')) {
    /**
     * Display structured debug information about one or more values in using Kint and halt
     * script execution afterwards. Accepts multiple arguments to dump.
     *
     * @param array ...$args
     */
    function ddd(...$args)
    {
        d(...$args);

        die;
    }

    // See https://kint-php.github.io/kint/advanced/#plugins
    Kint::$aliases[] = 'ddd';
}

if (! function_exists('sss_if')) {
    /**
     * Display structured debug information about one or more values in plain text using Kint
     * and halt script execution afterwards, but only if the condition is truthy. Does nothing
     * if falsy. Accepts multiple arguments to dump.
     *
     * @param mixed $condition
     * @param array ...$args
     */
    function sss_if($condition, ...$args)
    {
        if (! $condition) {
            return;
        }

        sss(...$args);
    }
}

if (! function_exists('ddd_if')) {
    /**
     * Display structured debug information about one or more values using Kint and halt script
     * execution afterwards, but only if the condition is truthy. Does nothing if falsy. Accepts
     * multiple arguments to dump.
     *
     * @param mixed $condition
     * @param array ...$args
     */
    function ddd_if($condition, ...$args)
    {
        if (! $condition) {
            return;
        }

        ddd(...$args);
    }
}
