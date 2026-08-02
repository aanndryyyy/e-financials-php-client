<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Products;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Products` schema, plus example-backed `is_deleted`.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-products_one
 *
 * @phpstan-type ProductData array{
 *     id: int|null,
 *     name: string,
 *     foreign_names: array<string, string>,
 *     cl_sale_articles_id: int|null,
 *     sale_accounts_id: int|null,
 *     sale_accounts_dimensions_id: int|null,
 *     cl_purchase_articles_id: int|null,
 *     purchase_accounts_id: int|null,
 *     purchase_accounts_dimensions_id: int|null,
 *     code: string,
 *     description: string|null,
 *     sales_price: float|null,
 *     net_price: float|null,
 *     price_currency: string|null,
 *     notes: string|null,
 *     translations: array<string, string>,
 *     activity_text: string|null,
 *     emtak_code: string|null,
 *     emtak_version: string|null,
 *     unit: string|null,
 *     amount: float|null,
 *     is_deleted: bool|null
 * }
 *
 * @implements ResponseContract<ProductData>
 */
final class ProductResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<ProductData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<string, string>  $foreignNames
     * @param  array<string, string>  $translations
     */
    private function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly array $foreignNames,
        public readonly ?int $clSaleArticlesId,
        public readonly ?int $saleAccountsId,
        public readonly ?int $saleAccountsDimensionsId,
        public readonly ?int $clPurchaseArticlesId,
        public readonly ?int $purchaseAccountsId,
        public readonly ?int $purchaseAccountsDimensionsId,
        public readonly string $code,
        public readonly ?string $description,
        public readonly ?float $salesPrice,
        public readonly ?float $netPrice,
        public readonly ?string $priceCurrency,
        public readonly ?string $notes,
        public readonly array $translations,
        public readonly ?string $activityText,
        public readonly ?string $emtakCode,
        public readonly ?string $emtakVersion,
        public readonly ?string $unit,
        public readonly ?float $amount,
        public readonly ?bool $isDeleted,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::stringValue($attributes['name'] ?? null),
            self::stringMap($attributes['foreign_names'] ?? null),
            self::intOrNull($attributes['cl_sale_articles_id'] ?? null),
            self::intOrNull($attributes['sale_accounts_id'] ?? null),
            self::intOrNull($attributes['sale_accounts_dimensions_id'] ?? null),
            self::intOrNull($attributes['cl_purchase_articles_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_dimensions_id'] ?? null),
            self::stringValue($attributes['code'] ?? null),
            self::stringOrNull($attributes['description'] ?? null),
            self::floatOrNull($attributes['sales_price'] ?? null),
            self::floatOrNull($attributes['net_price'] ?? null),
            self::stringOrNull($attributes['price_currency'] ?? null),
            self::stringOrNull($attributes['notes'] ?? null),
            self::stringMap($attributes['translations'] ?? null),
            self::stringOrNull($attributes['activity_text'] ?? null),
            self::stringOrNull($attributes['emtak_code'] ?? null),
            self::stringOrNull($attributes['emtak_version'] ?? null),
            self::stringOrNull($attributes['unit'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
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
            'name' => $this->name,
            'foreign_names' => $this->foreignNames,
            'cl_sale_articles_id' => $this->clSaleArticlesId,
            'sale_accounts_id' => $this->saleAccountsId,
            'sale_accounts_dimensions_id' => $this->saleAccountsDimensionsId,
            'cl_purchase_articles_id' => $this->clPurchaseArticlesId,
            'purchase_accounts_id' => $this->purchaseAccountsId,
            'purchase_accounts_dimensions_id' => $this->purchaseAccountsDimensionsId,
            'code' => $this->code,
            'description' => $this->description,
            'sales_price' => $this->salesPrice,
            'net_price' => $this->netPrice,
            'price_currency' => $this->priceCurrency,
            'notes' => $this->notes,
            'translations' => $this->translations,
            'activity_text' => $this->activityText,
            'emtak_code' => $this->emtakCode,
            'emtak_version' => $this->emtakVersion,
            'unit' => $this->unit,
            'amount' => $this->amount,
            'is_deleted' => $this->isDeleted,
        ];
    }
}
