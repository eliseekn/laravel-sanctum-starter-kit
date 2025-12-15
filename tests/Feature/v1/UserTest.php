<?php

namespace Tests\Feature\v1;

use App\Enums\HttpResponseStatus;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store(): void
    {
        $user = User::factory()->make();
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this
            ->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/users', $user->getAttributes())
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->where('user.email', $user->email)
                ->etc()
            );

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_user_with_role_user_can_not_store_user(): void
    {
        $user = User::factory()->make();

        $this
            ->actingAs(User::factory()->create(), 'sanctum')
            ->postJson('/api/v1/users', $user->getAttributes())
            ->assertStatus(403);
    }

    public function test_can_update(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);
        $name = fake()->name();

        $this
            ->actingAs($admin, 'sanctum')
            ->patchJson('/api/v1/users/'.$user->id, [
                'name' => $name,
            ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->where('user.name', $name)
                ->etc()
            );

        $this->assertDatabaseHas('users', [
            'name' => $name,
        ]);
    }

    public function test_user_with_role_user_can_not_update_user(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs(User::factory()->create(), 'sanctum')
            ->patchJson('/api/v1/users/'.$user->id, [
                'name' => fake()->name(),
            ])
            ->assertStatus(403);
    }

    public function test_can_delete(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this
            ->actingAs($admin, 'sanctum')
            ->deleteJson('/api/v1/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->where('message', 'User deleted successfully')
                ->etc()
            );

        $this->assertDatabaseMissing('users', [
            'name' => $user->email,
        ]);
    }

    public function test_user_with_role_user_can_not_delete_user(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs(User::factory()->create(), 'sanctum')
            ->deleteJson('/api/v1/users/'.$user->id)
            ->assertStatus(403);
    }

    public function test_can_get_collection(): void
    {
        $users = User::factory(5)->create();
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this
            ->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->has('data', 6)
                ->where('data.1.email', $users[1]->email)
                ->etc()
            );
    }

    public function test_can_get_item(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this
            ->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/users/'.$user->id)
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('data.name', $user->name)
                ->where('data.email', $user->email)
                ->etc()
            );
    }
}
