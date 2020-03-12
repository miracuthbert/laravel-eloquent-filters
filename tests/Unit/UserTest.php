<?php

namespace Miracuthbert\Filters\Tests\Unit;

use Miracuthbert\Filters\Tests\Models\User;
use Miracuthbert\Filters\Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test user model has filter scope.
     *
     * @test
     */
    public function user_model_has_filter_scope()
    {
        return $this->assertTrue(method_exists(new User(), 'scopeFilter'));
    }
}
