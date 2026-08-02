<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `SaleInvoicesItems` schema.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type SaleInvoiceItemData array{
 *     id: int|null,
 *     products_id: int|null,
 *     cl_sale_articles_id: int|null,
 *     sale_accounts_id: int|null,
 *     sale_accounts_dimensions_id: int|null,
 *     amount: float|null,
 *     unit: string|null,
 *     unit_net_price: float|null,
 *     total_net_price: float|null,
 *     base_total_net_price: float|null,
 *     vat_accounts_id: int|null,
 *     vat_rate: float|null,
 *     discount_percent: float|null,
 *     discount_amount: float|null,
 *     custom_title: string|null,
 *     projects_project_id: int|null,
 *     projects_location_id: int|null,
 *     projects_person_id: int|null,
 *     vat_amount: float|null
 * }
 *
 * @implements ResponseContract<SaleInvoiceItemData>
 */
final class SaleInvoiceItemResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<SaleInvoiceItemData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly ?int $productsId,
        public readonly ?int $clSaleArticlesId,
        public readonly ?int $saleAccountsId,
        public readonly ?int $saleAccountsDimensionsId,
        public readonly ?float $amount,
        public readonly ?string $unit,
        public readonly ?float $unitNetPrice,
        public readonly ?float $totalNetPrice,
        public readonly ?float $baseTotalNetPrice,
        public readonly ?int $vatAccountsId,
        public readonly ?float $vatRate,
        public readonly ?float $discountPercent,
        public readonly ?float $discountAmount,
        public readonly ?string $customTitle,
        public readonly ?int $projectsProjectId,
        public readonly ?int $projectsLocationId,
        public readonly ?int $projectsPersonId,
        public readonly ?float $vatAmount,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['products_id'] ?? null),
            self::intOrNull($attributes['cl_sale_articles_id'] ?? null),
            self::intOrNull($attributes['sale_accounts_id'] ?? null),
            self::intOrNull($attributes['sale_accounts_dimensions_id'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
            self::stringOrNull($attributes['unit'] ?? null),
            self::floatOrNull($attributes['unit_net_price'] ?? null),
            self::floatOrNull($attributes['total_net_price'] ?? null),
            self::floatOrNull($attributes['base_total_net_price'] ?? null),
            self::intOrNull($attributes['vat_accounts_id'] ?? null),
            self::floatOrNull($attributes['vat_rate'] ?? null),
            self::floatOrNull($attributes['discount_percent'] ?? null),
            self::floatOrNull($attributes['discount_amount'] ?? null),
            self::stringOrNull($attributes['custom_title'] ?? null),
            self::intOrNull($attributes['projects_project_id'] ?? null),
            self::intOrNull($attributes['projects_location_id'] ?? null),
            self::intOrNull($attributes['projects_person_id'] ?? null),
            self::floatOrNull($attributes['vat_amount'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'products_id' => $this->productsId,
            'cl_sale_articles_id' => $this->clSaleArticlesId,
            'sale_accounts_id' => $this->saleAccountsId,
            'sale_accounts_dimensions_id' => $this->saleAccountsDimensionsId,
            'amount' => $this->amount,
            'unit' => $this->unit,
            'unit_net_price' => $this->unitNetPrice,
            'total_net_price' => $this->totalNetPrice,
            'base_total_net_price' => $this->baseTotalNetPrice,
            'vat_accounts_id' => $this->vatAccountsId,
            'vat_rate' => $this->vatRate,
            'discount_percent' => $this->discountPercent,
            'discount_amount' => $this->discountAmount,
            'custom_title' => $this->customTitle,
            'projects_project_id' => $this->projectsProjectId,
            'projects_location_id' => $this->projectsLocationId,
            'projects_person_id' => $this->projectsPersonId,
            'vat_amount' => $this->vatAmount,
        ];
    }
}
