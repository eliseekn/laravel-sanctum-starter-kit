<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use RefreshDatabase;

    public function makeUser(array $attributes = []): User
    {
        return User::factory()->make($attributes);
    }

    public function createUser(array $attributes = []): User
    {
        $user = $this->makeUser(
            array_merge(
                $attributes, ['email_verified_at' => now()]
            )
        );
        $user->save();

        return $user;
    }
}
