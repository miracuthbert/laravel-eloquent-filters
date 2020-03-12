<?php

namespace Miracuthbert\Filters\Tests\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Miracuthbert\Filters\Tests\Filters\Users\UserFilters;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to include only "records" that match passed filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $request
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new UserFilters($request))->add($filters)->filter($builder);
    }
}
