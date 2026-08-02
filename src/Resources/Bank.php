<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Bank\BankAccountResponse;
use EFinancialsClient\Responses\Bank\ListResponse;
use EFinancialsClient\Responses\VatInfo\VatInfoResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Bank
{
    use Transportable;

    /**
     * Retrieve the bank account list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts
     */
    public function all(): ListResponse
    {
        $payload = Payload::get('bank_accounts');

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }

    /**
     * Retrieve one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts_one
     */
    public function get(int $id): BankAccountResponse
    {
        $payload = Payload::get('bank_accounts/'.$id);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->transporter->request($payload);

        return BankAccountResponse::from($response->data());
    }

    /**
     * Create a new bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-bank_accounts
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'account_name_est',
                    'account_no',
                ]
            ),
            $parameters
        );

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('bank_accounts', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-bank_accounts_one
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
    {
        $missingParameters = array_diff_key(
            array_flip(
                [
                    'account_name_est',
                    'account_no',
                ]
            ),
            $parameters
        );

        if (count($missingParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingParameters));

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('bank_accounts/'.$id, $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-bank_accounts_one
     *
     * @param  int  $id  Bank account identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete('bank_accounts/'.$id);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the VAT information of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-vat_info
     */
    public function getVatInfo(): VatInfoResponse
    {
        $payload = Payload::get('vat_info');

        /** @var Response<array{vat_number?: string|null, tax_refnumber?: string|null}> $response */
        $response = $this->transporter->request($payload);

        return VatInfoResponse::from($response->data());
    }
}
