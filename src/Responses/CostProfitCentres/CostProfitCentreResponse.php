<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\CostProfitCentres;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Projects` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type CostProfitCentreData array{
 *     id: int|null,
 *     parent_id: int|null,
 *     name: string,
 *     notes: string|null,
 *     cl_projects_type: string,
 *     is_disabled: bool,
 *     create_date: string|null,
 *     deprecated_parent_id: int|null,
 *     is_deleted: bool|null
 * }
 *
 * @implements ResponseContract<CostProfitCentreData>
 */
final class CostProfitCentreResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CostProfitCentreData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly ?int $parentId,
        public readonly string $name,
        public readonly ?string $notes,
        public readonly string $clProjectsType,
        public readonly bool $isDisabled,
        public readonly ?string $createDate,
        public readonly ?int $deprecatedParentId,
        public readonly ?bool $isDeleted,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['parent_id'] ?? null),
            self::stringValue($attributes['name'] ?? null),
            self::stringOrNull($attributes['notes'] ?? null),
            self::stringValue($attributes['cl_projects_type'] ?? null),
            self::boolValue($attributes['is_disabled'] ?? null),
            self::stringOrNull($attributes['create_date'] ?? null),
            self::intOrNull($attributes['deprecated_parent_id'] ?? null),
            self::boolOrNull($attributes['is_deleted'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'name' => $this->name,
            'notes' => $this->notes,
            'cl_projects_type' => $this->clProjectsType,
            'is_disabled' => $this->isDisabled,
            'create_date' => $this->createDate,
            'deprecated_parent_id' => $this->deprecatedParentId,
            'is_deleted' => $this->isDeleted,
        ];
    }
}
