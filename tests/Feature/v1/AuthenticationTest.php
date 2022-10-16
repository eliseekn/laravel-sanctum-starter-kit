<?php
declare(strict_types=1);

namespace Tests\Feature\v1;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\AbstractTestCase;

final class AuthenticationTest extends AbstractTestCase
{
    public function test_as_a_registered_user_i_can_log_in(): void
    {
        $user = $this->createUser();

        $this
            ->postJson('/api/v1/login', [
                'email' => $user->getAttribute('email'),
                'password' => 'password'
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User logged in successfully.')
                    ->where('user', $user->attributesToArray())
                    ->has('token')
                    ->etc()
            );
    }

    public function test_as_an_unregistered_user_i_can_register(): void
    {
        Notification::fake();

        $user = $this->makeUser([
            'password' => 'password'
        ]);

        $this
            ->postJson('/api/v1/register', $user->getAttributes())
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User registered successfully.')
                    ->etc()
            );

        Notification::assertSentTo(
            User::query()->first(),
            VerifyEmail::class
        );

        $this->assertDatabaseHas('users', [
            'email' => $user->getAttribute('email')]
        );
    }

    public function test_as_an_authenticated_user_i_can_log_out(): void
    {
        $user = $this->createUser();

        $this
            ->actingAs($user, 'sanctum')
            ->getJson('/api/v1/logout/' . $user->getAttribute('id'))
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User logged out successfully.')
                    ->etc()
            );
    }
}
