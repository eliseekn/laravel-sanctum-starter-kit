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

    public function test_as_an_authenticated_user_with_role_user_i_can_update_same_user(): void
    {
        $user = $this->createUser([
            'role' => UserRole::USER->value
        ]);

        $name = fake()->name();
        $user->setAttribute('name', $name);

        $this
            ->actingAs($user, 'sanctum')
            ->patchJson('/api/v1/users/' . $user->getAttribute('id'), $user->attributesToArray())
            ->assertJson(fn (AssertableJson $json) =>
            $json
                ->where('status', 'success')
                ->where('message', 'User updated successfully.')
                ->etc()
            );

        $this->assertDatabaseHas('users', ['name' => $name]);
    }
}
