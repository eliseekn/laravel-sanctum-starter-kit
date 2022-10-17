<?php

namespace Tests\Feature\v1;

use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\AccountCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\AbstractTestCase;

class UserTest extends AbstractTestCase
{
    public function test_as_an_authenticated_user_with_role_admin_i_can_create_user(): void
    {
        Notification::fake();

        $admin = $this->createUser([
            'role' => UserRole::ADMIN->value
        ]);

        $user = $this->makeUser([
            'password' => 'password'
        ]);

        $this
            ->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/users', $user->getAttributes())
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User created successfully.')
                    ->etc()
            );

        Notification::assertSentTo(
            User::query()->find(2),
            AccountCreated::class
        );

        $this->assertDatabaseHas('users', [
            'email' => $user->getAttribute('email')]
        );
    }
}
