<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{code: int, messages?: array<int, string>, created_object_id?: int|null}>
 */
final class ApiResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{code: int, messages?: array<int, string>, created_object_id?: int|null}>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, string>  $messages
     */
    private function __construct(
        public readonly int $code,
        public readonly array $messages,
        public readonly ?int $createdObjectId,
    ) {}

    /**
     * @param  array{code: int, messages?: array<int, string>, created_object_id?: int|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['code'],
            $attributes['messages'] ?? [],
            $attributes['created_object_id'] ?? null,
        );
    }

    public function successful(): bool
    {
        return $this->code === 0;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_filter([
            'code' => $this->code,
            'messages' => $this->messages,
            'created_object_id' => $this->createdObjectId,
        ], static fn (mixed $value): bool => $value !== null && $value !== []);
    }
}
