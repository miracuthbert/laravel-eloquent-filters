<?php

namespace Miracuthbert\Filters\Tests\Filters\Users;

use Illuminate\Http\Request;
use Miracuthbert\Filters\FiltersAbstract;
use Miracuthbert\Filters\Tests\Filters\EmailFilter;
use Miracuthbert\Filters\Tests\Filters\NameFilter;
use Miracuthbert\Filters\Tests\Filters\Ordering\CreatedOrder;

class UserFilters extends FiltersAbstract
{
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [
         'name' => NameFilter::class,
         'email' => EmailFilter::class,
         'created' => CreatedOrder::class,
    ];

    /**
     * A list of default filters.
     *
     * @var array
     */
    protected $defaultFilters = [
         'created' => 'desc',
    ];

    /**
     * UserFilters constructor
     * .
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // use block below to change default filters
        // if ($request->hasAny('cancelled', 'completed')) {
        //    $this->defaultFilters = [
        //        'upcoming' => 'false'
        //    ];
        // }

        parent::__construct($request);
    }

    /**
     * A list of filters map.
     *
     * @return array
     */
    public static function mappings()
    {
        $map = [
            'created' => [
                'map' => [
                    'desc' => 'Latest',
                    'asc' => 'Older'
                ],
                'heading' => 'Date Created'
            ],
        ];

        // auth filters
        if (auth()->check()) {
            $authMap = [];

            $map = array_merge($map, $authMap);
        }

        return $map;
    }
}
