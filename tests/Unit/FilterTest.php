<?php

namespace Miracuthbert\Filters\Tests\Unit;

use Miracuthbert\Filters\FilterAbstract;
use Miracuthbert\Filters\FiltersAbstract;
use Miracuthbert\Filters\Tests\Filters\NameFilter;
use Miracuthbert\Filters\Tests\Filters\Users\UserFilters;
use Miracuthbert\Filters\Tests\TestCase;

class FilterTest extends TestCase
{
    /**
     * Test a filter extends "FilterAbstract".
     * 
     * @test
     */
    public function filter_extends_filter_abstract()
    {
        $this->assertTrue(get_parent_class(new NameFilter()) === FilterAbstract::class);
    }

    /**
     * Test a filter extends "FiltersAbstract".
     *
     * @test
     */
    public function filter_extends_filters_abstract()
    {
        $this->assertTrue(get_parent_class(new UserFilters(request())) === FiltersAbstract::class);
    }
}
