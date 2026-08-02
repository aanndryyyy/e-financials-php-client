<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `ApiFile` schema.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type ApiFileData array{name: string, contents: string}
 *
 * @implements ResponseContract<ApiFileData>
 */
final class ApiFileResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<ApiFileData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly string $name,
        public readonly string $contents,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::stringValue($attributes['name'] ?? null),
            self::stringValue($attributes['contents'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'contents' => $this->contents,
        ];
    }
}
