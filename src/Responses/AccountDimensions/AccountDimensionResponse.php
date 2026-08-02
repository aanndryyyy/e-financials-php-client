<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\AccountDimensions;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `AccountsDimensions` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type AccountDimensionData array{
 *     id: int|null,
 *     accounts_id: int,
 *     title_est: string,
 *     title_eng: string|null,
 *     cl_currencies_id: string|null,
 *     is_deleted: bool|null,
 *     expenditure_accounts_dimensions_id: string|null,
 *     amortization_accounts_dimensions_id: string|null
 * }
 *
 * @implements ResponseContract<AccountDimensionData>
 */
final class AccountDimensionResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<AccountDimensionData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly int $accountsId,
        public readonly string $titleEst,
        public readonly ?string $titleEng,
        public readonly ?string $clCurrenciesId,
        public readonly ?bool $isDeleted,
        public readonly ?string $expenditureAccountsDimensionsId,
        public readonly ?string $amortizationAccountsDimensionsId,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intValue($attributes['accounts_id'] ?? null),
            self::stringValue($attributes['title_est'] ?? null),
            self::stringOrNull($attributes['title_eng'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::boolOrNull($attributes['is_deleted'] ?? null),
            self::stringOrNull($attributes['expenditure_accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['amortization_accounts_dimensions_id'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'accounts_id' => $this->accountsId,
            'title_est' => $this->titleEst,
            'title_eng' => $this->titleEng,
            'cl_currencies_id' => $this->clCurrenciesId,
            'is_deleted' => $this->isDeleted,
            'expenditure_accounts_dimensions_id' => $this->expenditureAccountsDimensionsId,
            'amortization_accounts_dimensions_id' => $this->amortizationAccountsDimensionsId,
        ];
    }
}
