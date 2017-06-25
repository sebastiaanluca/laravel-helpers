<?php

namespace SebastiaanLuca\Helpers\Html;

use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;

class HtmlBuilder extends CollectiveHtmlBuilder
{
    /**
     * Get the Bootstrap error class if the given field has a validation error.
     *
     * @param string $field
     *
     * @return string
     */
    public function highlightOnError(string $field) : string
    {
        /** @var \Illuminate\Contracts\Support\MessageBag $errors */
        $errors = app('session')->get('errors');

        if (! $errors || ! $errors->has($field)) {
            return '';
        }

        return 'has-danger';
    }

    /**
     * Get the Bootstrap error help block if the given field has a validation error.
     *
     * @param string $field
     *
     * @return string
     */
    public function error(string $field) : string
    {
        /** @var \Illuminate\Contracts\Support\MessageBag $errors */
        $errors = app('session')->get('errors');

        if (! $errors || ! $errors->has($field)) {
            return '';
        }

        return '<div class="form-control-feedback">' . $errors->first($field) . '</div>';
    }
}
