<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function getValues(): array
    {
        return array_map(
            fn ($case) => $case->value, self::cases()
        );
    }
}
