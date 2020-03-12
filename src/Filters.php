<?php

namespace Miracuthbert\Filters;

use Illuminate\Support\Arr;

class Filters
{
    /**
     * Get filters from request query.
     *
     * @param array|string $values
     * @return array
     */
    public function getFiltersFromRequest($values = 'page')
    {
        return Arr::except(request()->query(), array_merge($values));
    }

    /**
     * Add filter to query.
     *
     * @param string $key
     * @param array|string $value
     * @return array
     */
    public function addFilterToQuery($key, $value = [])
    {
        return array_merge(
            $this->getFiltersFromRequest(), [$key => $value]
        );
    }
}
