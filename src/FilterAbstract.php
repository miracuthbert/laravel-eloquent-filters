<?php

namespace Miracuthbert\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class FilterAbstract
{
    /**
     * Apply filter.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $value
     *
     * @return mixed
     */
    public abstract function filter(Builder $builder, $value);

    /**
     * Database value mappings.
     *
     * @return array
     */
    public function mappings()
    {
        return [];
    }

    /**
     * Database column mappings.
     *
     * @return array
     */
    public function columnMappings()
    {
        return [];
    }

    /**
     * Database where column mappings.
     *
     * @return array
     */
    public function whereMappings()
    {
        return [];
    }

    /**
     * Database operator mappings.
     *
     * @return array
     */
    public function operators()
    {
        return [];
    }

    /**
     * Resolve the column used for filtering.
     *
     * @param $key
     * @return mixed
     */
    public function resolveFilterColumn($key)
    {
        return Arr::get($this->columnMappings(), $key);
    }

    /**
     * Resolve the where clause used for filtering.
     *
     * @param $key
     * @return mixed
     */
    public function resolveWhereClause($key)
    {
        return Arr::get($this->whereMappings(), $key);
    }

    /**
     * Resolve the value used for filtering.
     *
     * @param $key
     * @return mixed
     */
    protected function resolveFilterValue($key)
    {
        return Arr::get($this->mappings(), $key);
    }

    /**
     * Resolve the operator used for filtering.
     *
     * @param $key
     * @return mixed
     */
    protected function resolveFilterOperator($key)
    {
        return Arr::get($this->operators(), $key);
    }

    /**
     * Resolve the order direction to be used.
     *
     * @param $direction
     * @return mixed
     */
    protected function resolveOrderDirection($direction)
    {
        return Arr::get([
            'desc' => 'desc',
            'asc' => 'asc',
        ], $direction, 'desc');
    }
}
