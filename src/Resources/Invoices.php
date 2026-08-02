<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\InvoicesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class Invoices implements InvoicesContract
{
    use Transportable;

    /**
     * Retrieve the invoice series list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     */
    public function all(): mixed
    {

        $payload = Payload::get('invoice_series');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
     */
    public function get(int $id): mixed
    {

        $payload = Payload::get('invoice_series/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

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
    public function create(array $parameters = []): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'is_active',
                    'is_default',
                    'number_prefix',
                    'number_start_value',
                    'term_days',
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

        $payload = Payload::post('invoice_series', $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

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
    public function update(int $id, array $parameters): mixed
    {

        $missingParameters = array_diff_key(
            array_flip(
                [
                    'is_active',
                    'is_default',
                    'number_prefix',
                    'number_start_value',
                    'term_days',
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

        $payload = Payload::patch('invoice_series/'.$id, $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-invoice_series_one
     *
     * @param  int  $id  Invoice series identificator.
     */
    public function delete(int $id): mixed
    {
        $payload = Payload::delete('invoice_series/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
     */
    public function allSettings(): mixed
    {

        $payload = Payload::get('invoice_info');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

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
    public function updateSettings(array $parameters): mixed
    {

        $payload = Payload::patch('invoice_info', $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
