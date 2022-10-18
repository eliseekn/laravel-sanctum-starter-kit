<?php

namespace Tests\Feature\v1;

use App\Enums\UserRole;
use App\Models\User;
use App\Notifications\AccountCreated;
use App\Notifications\AccountDeleted;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\AnonymousNotifiable;
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
        $user = $this->createUser();

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

    public function test_as_an_authenticated_user_with_role_user_i_can_update_same_user_avatar(): void
    {
        $user = $this->createUser();

        $this
            ->withoutExceptionHandling()
            ->actingAs($user, 'sanctum')
            ->patchJson('/api/v1/users/' . $user->getAttribute('id') . '/avatar', [
                'avatar' => UploadedFile::fake()->image('avatar.png')
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'Avatar updated successfully.')
                    ->etc()
            );

        $user = User::query()->first();
        $this->assertFileExists(storage_path('app/public') . '/' . $user->getAttribute('avatar'));
    }

    public function test_as_an_authenticated_user_with_role_admin_i_can_delete_user(): void
    {
        Notification::fake();

        $admin = $this->createUser([
            'role' => UserRole::ADMIN->value
        ]);

        $user = $this->createUser();

        $this
            ->actingAs($admin, 'sanctum')
            ->deleteJson('/api/v1/users/' . $user->getAttribute('id'))
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User deleted successfully.')
                    ->etc()
            );

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            AccountDeleted::class
        );

        $this->assertDatabaseMissing('users', [
            'email' => $user->getAttribute('email')]
        );
    }

    public function test_as_an_authenticated_user_with_role_admin_i_can_get_user_collection(): void
    {
        $admin = $this->createUser([
            'role' => UserRole::ADMIN->value
        ]);

        $user = $this->createUser();

        $this
            ->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users')
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('data', 2)
                    ->where('data.0.email', $admin->getAttribute('email'))
                    ->where('data.1.email', $user->getAttribute('email'))
                    ->etc()
            );
    }

    public function test_as_an_authenticated_user_with_role_admin_i_can_get_user_item(): void
    {
        $admin = $this->createUser([
            'role' => UserRole::ADMIN->value
        ]);

        $user = $this->createUser();

        $this
            ->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users/' . $user->getAttribute('id'))
            ->assertExactJson($user->toArray());
    }
}
