<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

interface InvoicesContract
{
    /**
     * Retrieve the invoice series list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     */
    public function all(): mixed;

    /**
     * Retrieve one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
     */
    public function get(int $id): mixed;

    /**
     * Create a new invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     *
     * @param array<string,mixed>|array{
     *   "is_active": true,
     *   "is_default": false,
     *   "number_prefix": string,
     *   "number_start_value": 1,
     *   "term_days": 28,
     *   "overdue_charge": 0.15,
     * } $parameters
     */
    public function create(array $parameters = []): mixed;

    /**
     * Modify one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_series_one
     *
     * @param array<string,mixed>|array{
     *   "is_active": true,
     *   "is_default": false,
     *   "number_prefix": string,
     *   "number_start_value": 1,
     *   "term_days": 28,
     *   "overdue_charge": 0.15,
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed;

    /**
     * Delete one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-invoice_series_one
     *
     * @param  int  $id  Invoice series identificator.
     */
    public function delete(int $id): mixed;

    /**
     * Retrieve the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
     */
    public function allSettings(): mixed;

    /**
     * Update the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_info
     *
     * @param array<string,mixed>|array{
     *   "address": string,
     *   "email": string,
     *   "phone": string,
     *   "fax": string,
     *   "webpage": string,
     *   "cl_templates_id": 1,
     *   "invoice_company_name": string,
     *   "invoice_email_subject": string,
     *   "invoice_email_body": string,
     *   "balance_email_subject": string,
     *   "balance_email_body": string,
     *   "balance_document_footer": string
     * } $parameters
     */
    public function updateSettings(array $parameters): mixed;
}
