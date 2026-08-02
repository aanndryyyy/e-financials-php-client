<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\VatInfo\VatInfoResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class Bank
{
    use Transportable;

    /**
     * Retrieve the bank account list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts
     */
    public function all(): mixed
    {

        $payload = Payload::get('bank_accounts');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts_one
     */
    public function get(int $id): mixed
    {

        $payload = Payload::get('bank_accounts/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Create a new bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-bank_accounts
     *
     * @param array<string,mixed>|array{
     *  "account_name_eng": "Swedbank AS EE123456780012345678",
     *  "account_name_est": "Swedbank AS EE123456780012345678",
     *  "account_no": "EE123456780012345678",
     *  "accounts_dimensions_id": 2,
     *  "bank_name": null,
     *  "bank_regcode": null,
     *  "beneficiary_name": null,
     *  "cl_banks_id": 1,
     *  "clients_id": 56,
     *  "credit_limit": null,
     *  "day_limit": null,
     *  "default_salary_account": true,
     *  "iban_code": "EE123456780012345678",
     *  "id": 16,
     *  "show_in_sale_invoices": true,
     *  "start_sum": null,
     *  "swift_code": "HABAEE2X"
     * } $parameters
     */
    public function create(array $parameters = []): mixed
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

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('bank_accounts', $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Modify one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-bank_accounts_one
     *
     * @param array<string,mixed>|array{
     *  "account_name_eng": "Swedbank AS EE123456780012345678",
     *  "account_name_est": "Swedbank AS EE123456780012345678",
     *  "account_no": "EE123456780012345678",
     *  "accounts_dimensions_id": 2,
     *  "bank_name": null,
     *  "bank_regcode": null,
     *  "beneficiary_name": null,
     *  "cl_banks_id": 1,
     *  "clients_id": 56,
     *  "credit_limit": null,
     *  "day_limit": null,
     *  "default_salary_account": true,
     *  "iban_code": "EE123456780012345678",
     *  "id": 16,
     *  "show_in_sale_invoices": true,
     *  "start_sum": null,
     *  "swift_code": "HABAEE2X"
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed
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

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('bank_accounts/'.$id, $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-bank_accounts_one
     *
     * @param  int  $id  Bank account identificator.
     */
    public function delete(int $id): mixed
    {
        $payload = Payload::delete('bank_accounts/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
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
