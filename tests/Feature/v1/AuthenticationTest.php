<?php
declare(strict_types=1);

namespace Tests\Feature\v1;

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
                    ->where('user', $user->attributesToArray())
                    ->has('token')
                    ->etc()
            );
    }

    public function test_as_an_unregistered_user_i_can_register(): void
    {
        $user = $this->makeUser([
            'password' => 'password'
        ]);

        $this
            ->postJson('/api/v1/register', $user->getAttributes())
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 'success')
                    ->where('message', 'User has been registered successfully.')
                    ->etc()
            );

        $this->assertDatabaseHas('users', [
            'email' => $user->getAttribute('email')]
        );
    }
}
