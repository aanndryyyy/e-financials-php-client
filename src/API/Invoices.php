<?php

namespace EFinancialsClient\API;

class Invoices extends AbstractAPI
{
    /**
     * Retrieve the invoice series list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     *
     * @return mixed
     */
    public function all(): mixed
    {

        $response = $this->client->request( 'GET', 'invoice_series' );

        return $response;
    }

    /**
     * Retrieve one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
     *
     * @return mixed
     */
    public function get( int $id ): mixed
    {

        $response = $this->client->request( 'GET', 'invoice_series/' . $id );

        return $response;
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
     *
     * @return mixed
     */
    public function create( array $parameters = [] ): mixed
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

        if ( count( $missingRequiredParameters ) !== 0 ) {
            $missingKeys = implode( ', ', array_keys( $missingRequiredParameters ) );

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $response = $this->client->request(
            'POST',
            'invoice_series',
            [],
            $parameters
        );

        return $response;
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
     *
     * @return mixed
     */
    public function update( int $id, array $parameters ): mixed
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

        if ( count( $missingParameters ) !== 0 ) {
            $missingKeys = implode( ', ', array_keys( $missingParameters ) );

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $response = $this->client->request(
            'PATCH',
            'invoice_series/' . $id,
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-invoice_series_one
     *
     * @param int $id Invoice series identificator.
     *
     * @return mixed
     */
    public function delete( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'invoice_series/' . $id );

        return $response;
    }

    /**
     * Retrieve the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
     *
     * @return mixed
     */
    public function allSettings(): mixed
    {

        $response = $this->client->request( 'GET', 'invoice_info' );

        return $response;
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
     *
     * @return mixed
     */
    public function updateSettings( array $parameters ): mixed
    {

        $response = $this->client->request(
            'PATCH',
            'invoice_info',
            [],
            $parameters
        );

        return $response;
    }
}
