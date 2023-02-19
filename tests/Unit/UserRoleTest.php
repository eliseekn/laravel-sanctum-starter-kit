<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_get_all_keys_is_correct(): void
    {
        $this->assertEquals(
            ['ADMIN', 'USER'], UserRole::getKeys()
        );
    }

    public function test_get_keys_is_correct(): void
    {
        $this->assertEquals(
            ['ADMIN'], UserRole::getKey(['ADMIN'])
        );
    }

    public function test_get_all_values_is_correct(): void
    {
        $this->assertEquals(
            ['admin', 'user'], UserRole::getValues()
        );
    }

    public function test_get_values_is_correct(): void
    {
        $this->assertEquals(
            ['admin'], UserRole::getValue(['admin'])
        );
    }
}
