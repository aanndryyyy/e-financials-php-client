<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\PurchaseInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `PurchaseInvoicesItems` schema.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type PurchaseInvoiceItemData array{
 *     id: int|null,
 *     cl_purchase_articles_id: int|null,
 *     purchase_accounts_id: int|null,
 *     purchase_accounts_dimensions_id: int|null,
 *     cl_fringe_benefits_id: int|null,
 *     amount: float|null,
 *     unit: string|null,
 *     unit_net_price: float|null,
 *     total_net_price: float|null,
 *     base_total_net_price: float|null,
 *     cl_vat_articles_id: int|null,
 *     vat_accounts_id: int|null,
 *     vat_accounts_dimensions_id: int|null,
 *     vat_rate_dropdown: string|null,
 *     vat_rate: float|null,
 *     custom_title: string|null,
 *     projects_project_id: int|null,
 *     projects_location_id: int|null,
 *     projects_person_id: int|null,
 *     reversed_vat_id: int|null,
 *     products_id: int|null,
 *     project_no_vat_gross_price: float|null
 * }
 *
 * @implements ResponseContract<PurchaseInvoiceItemData>
 */
final class PurchaseInvoiceItemResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<PurchaseInvoiceItemData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly ?int $clPurchaseArticlesId,
        public readonly ?int $purchaseAccountsId,
        public readonly ?int $purchaseAccountsDimensionsId,
        public readonly ?int $clFringeBenefitsId,
        public readonly ?float $amount,
        public readonly ?string $unit,
        public readonly ?float $unitNetPrice,
        public readonly ?float $totalNetPrice,
        public readonly ?float $baseTotalNetPrice,
        public readonly ?int $clVatArticlesId,
        public readonly ?int $vatAccountsId,
        public readonly ?int $vatAccountsDimensionsId,
        public readonly ?string $vatRateDropdown,
        public readonly ?float $vatRate,
        public readonly ?string $customTitle,
        public readonly ?int $projectsProjectId,
        public readonly ?int $projectsLocationId,
        public readonly ?int $projectsPersonId,
        public readonly ?int $reversedVatId,
        public readonly ?int $productsId,
        public readonly ?float $projectNoVatGrossPrice,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['cl_purchase_articles_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_dimensions_id'] ?? null),
            self::intOrNull($attributes['cl_fringe_benefits_id'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
            self::stringOrNull($attributes['unit'] ?? null),
            self::floatOrNull($attributes['unit_net_price'] ?? null),
            self::floatOrNull($attributes['total_net_price'] ?? null),
            self::floatOrNull($attributes['base_total_net_price'] ?? null),
            self::intOrNull($attributes['cl_vat_articles_id'] ?? null),
            self::intOrNull($attributes['vat_accounts_id'] ?? null),
            self::intOrNull($attributes['vat_accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['vat_rate_dropdown'] ?? null),
            self::floatOrNull($attributes['vat_rate'] ?? null),
            self::stringOrNull($attributes['custom_title'] ?? null),
            self::intOrNull($attributes['projects_project_id'] ?? null),
            self::intOrNull($attributes['projects_location_id'] ?? null),
            self::intOrNull($attributes['projects_person_id'] ?? null),
            self::intOrNull($attributes['reversed_vat_id'] ?? null),
            self::intOrNull($attributes['products_id'] ?? null),
            self::floatOrNull($attributes['project_no_vat_gross_price'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'cl_purchase_articles_id' => $this->clPurchaseArticlesId,
            'purchase_accounts_id' => $this->purchaseAccountsId,
            'purchase_accounts_dimensions_id' => $this->purchaseAccountsDimensionsId,
            'cl_fringe_benefits_id' => $this->clFringeBenefitsId,
            'amount' => $this->amount,
            'unit' => $this->unit,
            'unit_net_price' => $this->unitNetPrice,
            'total_net_price' => $this->totalNetPrice,
            'base_total_net_price' => $this->baseTotalNetPrice,
            'cl_vat_articles_id' => $this->clVatArticlesId,
            'vat_accounts_id' => $this->vatAccountsId,
            'vat_accounts_dimensions_id' => $this->vatAccountsDimensionsId,
            'vat_rate_dropdown' => $this->vatRateDropdown,
            'vat_rate' => $this->vatRate,
            'custom_title' => $this->customTitle,
            'projects_project_id' => $this->projectsProjectId,
            'projects_location_id' => $this->projectsLocationId,
            'projects_person_id' => $this->projectsPersonId,
            'reversed_vat_id' => $this->reversedVatId,
            'products_id' => $this->productsId,
            'project_no_vat_gross_price' => $this->projectNoVatGrossPrice,
        ];
    }
}
