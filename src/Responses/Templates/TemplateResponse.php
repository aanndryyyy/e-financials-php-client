<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Templates;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{id: int, name: string, is_default: bool, cl_languages_id: string|null}>
 */
final class TemplateResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: int, name: string, is_default: bool, cl_languages_id: string|null}>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly bool $isDefault,
        public readonly ?string $clLanguagesId,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intValue($attributes['id'] ?? 0),
            self::stringValue($attributes['name'] ?? ''),
            self::boolValue($attributes['is_default'] ?? false),
            self::stringOrNull($attributes['cl_languages_id'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_default' => $this->isDefault,
            'cl_languages_id' => $this->clLanguagesId,
        ];
    }
}
