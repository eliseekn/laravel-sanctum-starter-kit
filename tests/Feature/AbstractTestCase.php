<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use RefreshDatabase;

    public function makeUserWithRoleUser(array $attributes = []): User
    {
        return User::factory()->make(
            array_merge(
                $attributes, ['role' => UserRole::USER]
            )
        );
    }

    public function createUserWithRoleUser(array $attributes = []): User
    {
        $user = $this->makeUserWithRoleUser(
            array_merge(
                $attributes, ['email_verified_at' => now()]
            )
        );
        $user->save();

        return $user;
    }

    public function makeUserWithRoleAdmin(array $attributes = []): User
    {
        return User::factory()->make(
            array_merge(
                $attributes, ['role' => UserRole::ADMIN]
            )
        );
    }

    public function createUserWithRoleAdmin(array $attributes = []): User
    {
        $user = $this->makeUserWithRoleAdmin(
            array_merge(
                $attributes, ['email_verified_at' => now()]
            )
        );
        $user->save();

        return $user;
    }
}
