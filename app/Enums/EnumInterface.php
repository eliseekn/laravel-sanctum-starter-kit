<?php

declare(strict_types=1);

namespace App\Enums;

interface EnumInterface
{
    public static function getKeys(array $keys): array;

    public static function getAllKeys(): array;

    public static function getValues(array $values): array;

    public static function getAllValues(): array;
}
