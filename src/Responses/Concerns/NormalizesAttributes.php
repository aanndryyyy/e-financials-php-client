<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Concerns;

/**
 * @internal
 */
trait NormalizesAttributes
{
    private static function stringOrNull(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        return null;
    }

    private static function stringValue(mixed $value, string $default = ''): string
    {
        return self::stringOrNull($value) ?? $default;
    }

    private static function intOrNull(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }

    private static function intValue(mixed $value, int $default = 0): int
    {
        return self::intOrNull($value) ?? $default;
    }

    private static function floatOrNull(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_float($value)) {
            return $value;
        }

        if (is_int($value) || (is_string($value) && is_numeric($value))) {
            return (float) $value;
        }

        return null;
    }

    private static function boolOrNull(mixed $value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_string($value)) {
            return (bool) $value;
        }

        return null;
    }

    private static function boolValue(mixed $value, bool $default = false): bool
    {
        return self::boolOrNull($value) ?? $default;
    }

    /**
     * @return array<int, string>
     */
    private static function stringList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $list = [];

        foreach ($value as $item) {
            $string = self::stringOrNull($item);

            if ($string === null) {
                continue;
            }

            $list[] = $string;
        }

        return $list;
    }

    /**
     * @return array<int, int>
     */
    private static function intList(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $list = [];

        foreach ($value as $item) {
            $int = self::intOrNull($item);

            if ($int === null) {
                continue;
            }

            $list[] = $int;
        }

        return $list;
    }

    /**
     * @return array<string, string>
     */
    private static function stringMap(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $map = [];

        foreach ($value as $key => $item) {
            $mapKey = is_string($key) ? $key : (string) $key;

            if ($item === null) {
                $map[$mapKey] = '';

                continue;
            }

            if (is_string($item) || is_int($item) || is_float($item)) {
                $map[$mapKey] = (string) $item;
            }
        }

        return $map;
    }
}
