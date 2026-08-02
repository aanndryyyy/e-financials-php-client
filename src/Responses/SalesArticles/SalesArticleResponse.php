<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesArticles;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `SaleArticles` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type SalesArticleData array{
 *     id: int|null,
 *     group_est: string,
 *     group_eng: string,
 *     name_est: string,
 *     name_eng: string,
 *     accounts_id: int,
 *     vat_accounts_id: int|null,
 *     vat_rate: float|null,
 *     vat_type: int,
 *     is_valid: bool,
 *     start_date: string|null,
 *     end_date: string|null,
 *     priority: int|null,
 *     cl_account_groups: array<int, string>,
 *     description_est: string|null,
 *     description_eng: string|null
 * }
 *
 * @implements ResponseContract<SalesArticleData>
 */
final class SalesArticleResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<SalesArticleData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, string>  $clAccountGroups
     */
    private function __construct(
        public readonly ?int $id,
        public readonly string $groupEst,
        public readonly string $groupEng,
        public readonly string $nameEst,
        public readonly string $nameEng,
        public readonly int $accountsId,
        public readonly ?int $vatAccountsId,
        public readonly ?float $vatRate,
        public readonly int $vatType,
        public readonly bool $isValid,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?int $priority,
        public readonly array $clAccountGroups,
        public readonly ?string $descriptionEst,
        public readonly ?string $descriptionEng,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::stringValue($attributes['group_est'] ?? null),
            self::stringValue($attributes['group_eng'] ?? null),
            self::stringValue($attributes['name_est'] ?? null),
            self::stringValue($attributes['name_eng'] ?? null),
            self::intValue($attributes['accounts_id'] ?? null),
            self::intOrNull($attributes['vat_accounts_id'] ?? null),
            self::floatOrNull($attributes['vat_rate'] ?? null),
            self::intValue($attributes['vat_type'] ?? null),
            self::boolValue($attributes['is_valid'] ?? null),
            self::stringOrNull($attributes['start_date'] ?? null),
            self::stringOrNull($attributes['end_date'] ?? null),
            self::intOrNull($attributes['priority'] ?? null),
            self::stringList($attributes['cl_account_groups'] ?? null),
            self::stringOrNull($attributes['description_est'] ?? null),
            self::stringOrNull($attributes['description_eng'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'group_est' => $this->groupEst,
            'group_eng' => $this->groupEng,
            'name_est' => $this->nameEst,
            'name_eng' => $this->nameEng,
            'accounts_id' => $this->accountsId,
            'vat_accounts_id' => $this->vatAccountsId,
            'vat_rate' => $this->vatRate,
            'vat_type' => $this->vatType,
            'is_valid' => $this->isValid,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'priority' => $this->priority,
            'cl_account_groups' => $this->clAccountGroups,
            'description_est' => $this->descriptionEst,
            'description_eng' => $this->descriptionEng,
        ];
    }
}
