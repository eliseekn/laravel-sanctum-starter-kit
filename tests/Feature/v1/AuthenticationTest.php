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
}
