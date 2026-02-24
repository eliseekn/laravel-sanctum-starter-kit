<?php

declare(strict_types=1);

namespace Tests\Feature\v1;

use App\Enums\HttpResponseStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_user_can_log_in(): void
    {
        $user = User::factory()->create();

        $this
            ->postJson('/api/v1/login', [
                'email' => $user->email,
                'password' => 'password',
            ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->where('user.name', $user->name)
                ->where('user.email', $user->email)
                ->has('token')
                ->etc()
            );
    }

    public function test_unregistered_user_can_not_log_in(): void
    {
        $this
            ->postJson('/api/v1/login', [
                'email' => fake()->unique()->safeEmail(),
                'password' => 'password',
            ])
            ->assertStatus(403)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::ERROR)
                ->etc()
            );
    }

    public function test_can_not_login_with_missing_data(): void
    {
        $this
            ->postJson('/api/v1/login')
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::ERROR)
                ->has('errors.email')
                ->has('errors.password')
                ->etc()
            );
    }

    public function test_unregistered_user_can_register(): void
    {
        $user = User::factory()->make([
            'password' => 'password',
        ]);

        $this
            ->postJson('/api/v1/register', $user->getAttributes())
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->where('user.email', $user->email)
                ->etc()
            );

        $user = User::query()->first();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_can_not_register_with_missing_data(): void
    {
        $user = User::factory()->make([
            'email' => null,
        ]);

        $this
            ->postJson('/api/v1/register', $user->getAttributes())
            ->assertStatus(400)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::ERROR)
                ->has('errors.email')
                ->etc()
            );
    }

    public function test_can_logout(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/v1/logout')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', HttpResponseStatus::SUCCESS)
                ->etc()
            );
    }

    public function test_can_not_logout_if_not_authenticated(): void
    {
        $this
            ->postJson('/api/v1/logout')
            ->assertStatus(401);
    }
}
