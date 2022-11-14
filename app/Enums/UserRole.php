<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string implements EnumInterface
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function getAllKeys(): array
    {
        return array_map(
            fn ($case) => $case->name, self::cases()
        );
    }

    public static function getKeys(array $keys): array
    {
        return array_filter(self::getAllKeys(), function ($key) use ($keys) {
            return in_array($key, $keys);
        });
    }

    public static function getAllValues(): array
    {
        return array_map(
            fn ($case) => $case->value, self::cases()
        );
    }

    public static function getValues(array $values): array
    {
        return array_filter(self::getAllValues(), function ($value) use ($values) {
            return in_array($value, $values);
        });
    }
}
