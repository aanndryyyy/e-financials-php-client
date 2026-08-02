<?php

namespace EFinancialsClient\API;

class Bank extends AbstractAPI
{
    /**
     * Retrieve the bank account list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts
     */
    public function all(): mixed
    {

        $response = $this->client->request('GET', 'bank_accounts');

        return $response;
    }

    /**
     * Retrieve one specific bank account of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-bank_accounts_one
     */
    public function get(int $id): mixed
    {

        $response = $this->client->request('GET', 'bank_accounts/'.$id);

        return $response;
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

        $response = $this->client->request(
            'POST',
            'bank_accounts',
            [],
            $parameters
        );

        return $response;
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

        $response = $this->client->request(
            'PATCH',
            'bank_accounts/'.$id,
            [],
            $parameters
        );

        return $response;
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
        $response = $this->client->request('DELETE', 'bank_accounts/'.$id);

        return $response;
    }

    /**
     * Retrieve the VAT information of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-vat_info
     */
    public function getVatInfo(): mixed
    {

        $response = $this->client->request('GET', 'vat_info');

        return $response;
    }
}
