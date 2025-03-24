<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => UserRole::ADMIN,
            'email_verified_at' => now(),
        ]);

        User::factory(5)->create([
            'email_verified_at' => now(),
        ]);
    }
}
