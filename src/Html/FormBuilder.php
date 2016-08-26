<?php

namespace SebastiaanLuca\Helpers\Html;

use Collective\Html\FormBuilder as CollectiveFormBuilder;
use DateTime;

class FormBuilder extends CollectiveFormBuilder
{
    /**
     * Create a spoofed date input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function date($name, $value = null, $options = [])
    {
        // The value passed as an argument will be empty most
        // of the time, so get the actual value another way
        $date = $value ? $value : $this->getValueAttribute($name, $value);
        
        // Format the date using the date formatter
        if ($date instanceof DateTime) {
            $date = $date->format('d/m/Y');
        }
        
        // Add a date class so we know it's a date input text field
        $options['class'] = trim(array_get($options, 'class', '') . ' input-date');
        
        // The data-locale tag gets read by our Bootstrap datepicker
        // implementation and formats the date correctly. This should
        // be based on the current application's locale.
        if (! array_key_exists('data-language', $options)) {
            $options['data-locale'] = config('app.locale', config('app.fallback_locale'));
        }
        
        if (! array_key_exists('data-date-format', $options)) {
            $options['data-date-format'] = 'dd/mm/yyyy';
        }
        
        // Opting for a text input field here as date fields
        // have no consistent support yet
        return $this->input('text', $name, $date, $options);
    }
}
