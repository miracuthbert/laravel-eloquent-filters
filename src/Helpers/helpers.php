<?php

if (!function_exists('filters_query')) {
    /**
     * Filters passed values from the request query
     *
     * @param array|string $values
     * @return array
     */
    function filters_query($values = 'page')
    {
        return Filters::getFiltersFromRequest($values);
    }
}

if (!function_exists('add_filter_query')) {
    /**
     * Add a filter to the request query
     *
     * @param string $key
     * @param array|string $value
     * @return array
     */
    function add_filter_query($key, $value = [])
    {
        return Filters::addFilter($key, $value);
    }
}
