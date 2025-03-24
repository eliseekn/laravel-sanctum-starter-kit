<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    const ADMIN = 'admin';

    const USER = 'user';
}
