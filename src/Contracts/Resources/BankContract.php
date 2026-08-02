<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Bank\BankAccountResponse;
use EFinancialsClient\Responses\Bank\ListResponse;
use EFinancialsClient\Responses\VatInfo\VatInfoResponse;

interface BankContract
{
    /**
     * Retrieve the bank account list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts
     */
    public function all(): ListResponse;

    /**
     * Retrieve one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts_one
     */
    public function get(int $id): BankAccountResponse;

    /**
     * Create a new bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-bank_accounts
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-bank_accounts_one
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-bank_accounts_one
     *
     * @param  int  $id  Bank account identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Retrieve the VAT information of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-vat_info
     */
    public function getVatInfo(): VatInfoResponse;
}
