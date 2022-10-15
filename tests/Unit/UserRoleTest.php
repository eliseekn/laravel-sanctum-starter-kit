<?php


use App\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_admin_role_value_is_correct(): void
    {
        $this->assertEquals('admin', UserRole::ADMIN->value);
    }

    public function test_user_role_value_is_correct(): void
    {
        $this->assertEquals('user', UserRole::USER->value);
    }

    public function test_roles_values_is_correct(): void
    {
        $this->assertEquals([
            'admin',
            'user'
        ], UserRole::getValues());
    }
}
