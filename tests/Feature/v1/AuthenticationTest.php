<?php

declare(strict_types=1);

namespace Tests\Feature\v1;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Fixtures;

final class AuthenticationTest extends Fixtures
{
    public function test_as_a_registered_user_i_can_log_in(): void
    {
        $user = $this->createUserWithRoleUser();

        $this
            ->postJson('/api/v1/login', [
                'email' => $user->email,
                'password' => 'password',
            ])
            ->assertJson(fn (AssertableJson $json) => $json
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

        $user = $this->makeUserWithRoleUser([
            'password' => Str::password(),
        ]);

        $this
            ->withoutExceptionHandling()
            ->postJson('/api/v1/register', $user->getAttributes())
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('message', 'User registered successfully.')
                ->etc()
            );

        Notification::assertSentTo(
            User::query()->first(),
            VerifyEmail::class
        );

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_as_an_authenticated_user_i_can_log_out(): void
    {
        $user = $this->createUserWithRoleUser();

        $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/v1/logout', [
                'email' => $user->email,
            ])
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('message', 'User logged out successfully.')
                ->etc()
            );
    }

    public function test_as_a_registered_user_i_can_request_email_verification_link(): void
    {
        Notification::fake();

        $user = $this->createUserWithRoleUser();

        $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/v1/email/verification-notification', [
                'email' => $user->email,
            ])
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('message', 'Email verification notification sent successfully.')
                ->etc()
            );

        Notification::assertSentTo(
            User::query()->first(),
            VerifyEmail::class
        );
    }

    public function test_as_a_registered_user_i_can_request_password_reset(): void
    {
        Notification::fake();

        $user = $this->createUserWithRoleUser();

        $this
            ->actingAs($user, 'sanctum')
            ->postJson('/api/v1/password/reset-notification', [
                'email' => $user->email,
            ])
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('message', 'We have emailed your password reset link!')
                ->etc()
            );

        Notification::assertSentTo(
            User::query()->first(),
            ResetPassword::class
        );
    }
}
