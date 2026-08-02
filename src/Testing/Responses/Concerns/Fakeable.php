<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Concerns;

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

        /** @var array<array-key, mixed> $attributes */
        $attributes = array_replace_recursive($class::ATTRIBUTES, $override);

        return static::from($attributes);
    }
}
