<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\PurchaseArticles;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `PurchaseArticles` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type PurchaseArticleData array{
 *     id: int|null,
 *     level: int,
 *     name_est: string,
 *     name_eng: string,
 *     accounts_id: int|null,
 *     priority: int|null,
 *     cl_account_groups: array<int, string>,
 *     is_disabled: bool|null
 * }
 *
 * @implements ResponseContract<PurchaseArticleData>
 */
final class PurchaseArticleResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<PurchaseArticleData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, string>  $clAccountGroups
     */
    private function __construct(
        public readonly ?int $id,
        public readonly int $level,
        public readonly string $nameEst,
        public readonly string $nameEng,
        public readonly ?int $accountsId,
        public readonly ?int $priority,
        public readonly array $clAccountGroups,
        public readonly ?bool $isDisabled,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intValue($attributes['level'] ?? null),
            self::stringValue($attributes['name_est'] ?? null),
            self::stringValue($attributes['name_eng'] ?? null),
            self::intOrNull($attributes['accounts_id'] ?? null),
            self::intOrNull($attributes['priority'] ?? null),
            self::stringList($attributes['cl_account_groups'] ?? null),
            self::boolOrNull($attributes['is_disabled'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'name_est' => $this->nameEst,
            'name_eng' => $this->nameEng,
            'accounts_id' => $this->accountsId,
            'priority' => $this->priority,
            'cl_account_groups' => $this->clAccountGroups,
            'is_disabled' => $this->isDisabled,
        ];
    }
}
