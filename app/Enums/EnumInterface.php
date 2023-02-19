<?php

declare(strict_types=1);

namespace App\Enums;

interface EnumInterface
{
    public static function getKey(array $keys): array;

    public static function getKeys(): array;

    public static function getValue(array $values): array;

    public static function getValues(): array;
}
