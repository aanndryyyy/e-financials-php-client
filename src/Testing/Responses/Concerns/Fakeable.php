<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Concerns;

use RuntimeException;

trait Fakeable
{
    /**
     * @param  array<string, mixed>  $override
     */
    public static function fake(array $override = []): static
    {
        $class = str_replace(
            'EFinancialsClient\\Responses\\',
            'EFinancialsClient\\Testing\\Responses\\Fixtures\\',
            static::class
        ).'Fixture';

        if (! class_exists($class)) {
            throw new RuntimeException("Missing fixture class [{$class}] for response [".static::class.'].');
        }

        if (! defined("{$class}::ATTRIBUTES")) {
            throw new RuntimeException("Fixture [{$class}] must define an ATTRIBUTES constant.");
        }

        /** @var array<array-key, mixed> $attributes */
        $attributes = array_replace_recursive($class::ATTRIBUTES, $override);

        return static::from($attributes);
    }
}
