<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Transactions;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `TransactionsItems` schema.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type TransactionItemData array{
 *     id: int|null,
 *     accounts_id: int|null,
 *     accounts_dimensions_id: int|null,
 *     relation_table: string|null,
 *     relation_id: int|null,
 *     amount: float|null,
 *     base_amount: float|null,
 *     currency_rate: float|null,
 *     cl_currencies_id: string|null
 * }
 *
 * @implements ResponseContract<TransactionItemData>
 */
final class TransactionItemResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<TransactionItemData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly ?int $accountsId,
        public readonly ?int $accountsDimensionsId,
        public readonly ?string $relationTable,
        public readonly ?int $relationId,
        public readonly ?float $amount,
        public readonly ?float $baseAmount,
        public readonly ?float $currencyRate,
        public readonly ?string $clCurrenciesId,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['accounts_id'] ?? null),
            self::intOrNull($attributes['accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['relation_table'] ?? null),
            self::intOrNull($attributes['relation_id'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
            self::floatOrNull($attributes['base_amount'] ?? null),
            self::floatOrNull($attributes['currency_rate'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
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
            'accounts_dimensions_id' => $this->accountsDimensionsId,
            'relation_table' => $this->relationTable,
            'relation_id' => $this->relationId,
            'amount' => $this->amount,
            'base_amount' => $this->baseAmount,
            'currency_rate' => $this->currencyRate,
            'cl_currencies_id' => $this->clCurrenciesId,
        ];
    }
}
