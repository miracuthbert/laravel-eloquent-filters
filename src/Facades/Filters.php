<?php

namespace Miracuthbert\Filters\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Miracuthbert\Filters\Filters
 */
class Filters extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'filters';
    }
}
