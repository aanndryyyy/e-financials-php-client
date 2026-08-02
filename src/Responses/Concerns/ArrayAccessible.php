<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Concerns;

use BadMethodCallException;

/**
 * @template TArray of array
 */
trait ArrayAccessible
{
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->toArray());
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->toArray()[$offset]; // @phpstan-ignore-line
    }

    /**
     * @param  key-of<TArray>|null  $offset
     * @param  value-of<TArray>  $value
     */
    public function offsetSet(mixed $offset, mixed $value): never
    {
        throw new BadMethodCallException('Cannot set response attributes.');
    }

    public function offsetUnset(mixed $offset): never
    {
        throw new BadMethodCallException('Cannot unset response attributes.');
    }
}
