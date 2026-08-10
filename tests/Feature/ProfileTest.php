<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_profile(): void
    {
        $user = User::factory()->create();
        $name = fake()->name();

        $this
            ->actingAs($user, 'sanctum')
            ->patchJson('/api/profile/'.$user->id.'/update', [
                'name' => $name,
            ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('data.name', $name)
                ->etc()
            );

        $this->assertDatabaseHas('users', [
            'name' => $name,
        ]);
    }

    public function test_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this
            ->actingAs($user, 'sanctum')
            ->patchJson('/api/profile/'.$user->id.'/update-password', [
                'old_password' => 'password',
                'new_password' => 'Pa$$w0rd!',
            ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->etc()
            );

        $user = User::query()->first();

        $this->assertTrue(Hash::check('Pa$$w0rd!', $user->password));
    }
}
