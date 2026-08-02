<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Invoices\InvoiceInfoResponse;
use EFinancialsClient\Responses\Invoices\InvoiceSeriesResponse;
use EFinancialsClient\Responses\Invoices\ListResponse;

interface InvoicesContract
{
    /**
     * Retrieve the invoice series list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     */
    public function all(): ListResponse;

    /**
     * Retrieve one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
     */
    public function get(int $id): InvoiceSeriesResponse;

    /**
     * Create a new invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-invoice_series
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_series_one
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-invoice_series_one
     *
     * @param  int  $id  Invoice series identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Retrieve the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
     */
    public function allSettings(): InvoiceInfoResponse;

    /**
     * Update the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_info
     *
     * @param  array<string, mixed>  $parameters
     */
    public function updateSettings(array $parameters): ApiResponse;
}
