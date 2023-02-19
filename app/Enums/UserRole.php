<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string implements EnumInterface
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function getKeys(): array
    {
        return array_map(
            fn ($case) => $case->name, self::cases()
        );
    }

    public static function getKey(array $keys): array
    {
        return array_filter(self::getKeys(), function ($key) use ($keys) {
            return in_array($key, $keys);
        });
    }

    public static function getValues(): array
    {
        return array_map(
            fn ($case) => $case->value, self::cases()
        );
    }

    public static function getValue(array $values): array
    {
        return array_filter(self::getValues(), function ($value) use ($values) {
            return in_array($value, $values);
        });
    }
}
