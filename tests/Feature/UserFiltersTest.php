<?php

namespace Miracuthbert\Filters\Tests\Feature;

use Miracuthbert\Filters\Tests\Models\User;
use Miracuthbert\Filters\Tests\TestCase;

class UserFiltersTest extends TestCase
{
    /**
     * Test a user can be filtered by "name".
     *
     * @test
     */
    public function users_can_be_filtered_by_name()
    {
        $name = "John Doe";

        $user = factory(User::class)->create([
            'name' => $name,
        ]);

        $this->assertCount(1, User::get());

        $request = request()->instance();

        $request->merge(['name' => $name]);

        $users = factory(User::class, 10)->create();

        $this->assertCount(11, User::get());

        $this->assertCount(1, User::filter($request)->get());
    }

    /**
     * Test a user can be filtered by "email".
     *
     * @test
     */
    public function users_can_be_filtered_by_email()
    {
        $email = "johndoe@example.org";

        $user = factory(User::class)->create([
            'email' => $email,
        ]);

        $this->assertCount(1, User::get());

        $request = request()->instance();

        $request->merge(['email' => $email]);

        $users = factory(User::class, 10)->create();

        $this->assertCount(11, User::get());

        $this->assertCount(1, User::filter($request)->get());
    }

    /**
     * Test users can be filtered by oldest first.
     *
     * @test
     */
    public function users_can_be_filtered_by_oldest_first()
    {
        $email = "johndoe@example.org";

        $user = factory(User::class)->create([
            'email' => $email,
        ]);

        $this->assertCount(1, User::get());

        $request = request()->instance();

        $request->merge(['created' => 'asc']);

        $users = factory(User::class, 10)->create();

        $this->assertCount(11, User::get());

        $this->assertTrue($user->email === User::filter($request)->first()->email);
    }

    /**
     * Test users can be filtered by latest first.
     *
     * @test
     */
    public function users_can_be_filtered_by_latest_first()
    {
        $email = "johndoe@example.org";

        $users = factory(User::class, 10)->create();

        $this->assertCount(10, User::get());

        $request = request()->instance();

        $request->merge(['created' => 'desc']);

        $user = factory(User::class)->create([
            'email' => $email,
            'created_at' => now()->addSeconds(10),
        ]);

        $this->assertCount(11, User::get());

        $this->assertTrue($user->email === User::filter($request)->first()->email);
    }

    /**
     * Test users can be filtered by default filters.
     *
     * @test
     */
    public function users_can_be_filtered_by_default_filters()
    {
        $email = "johndoe@example.org";

        $users = factory(User::class, 10)->create();

        $this->assertCount(10, User::get());

        $request = request()->instance();

        $user = factory(User::class)->create([
            'email' => $email,
            'created_at' => now()->addSeconds(10),
        ]);

        $this->assertCount(11, User::get());

        $this->assertTrue($user->email === User::filter($request)->first()->email);
    }
}
