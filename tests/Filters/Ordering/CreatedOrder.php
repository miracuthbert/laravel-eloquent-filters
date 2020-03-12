<?php

namespace Miracuthbert\Filters\Tests\Filters\Ordering;

use Illuminate\Database\Eloquent\Builder;
use Miracuthbert\Filters\FilterAbstract;

class CreatedOrder extends FilterAbstract
{
    /**
     * Apply filter to order by "created_at" column.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter(Builder $builder, $value)
    {
        return $builder->orderBy('created_at', $this->resolveOrderDirection($value));
    }
}
