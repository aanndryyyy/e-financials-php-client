<?php

namespace EFinancialsClient\API;

use DateTime;

class SalesInvoices extends AbstractAPI
{
    /**
     * Retrieve the sale invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices
     *
     * @param int             $page Page of responses to return.
     * @param DateTime|string $modifiedSince Return only objects modified since provided timestamp.
     * @param DateTime|string $startDate Object revenue date on given date or later.
     * @param DateTime|string $endDate Object revenue date on given date or before.
     * @param string          $status Object status.
     * @param string          $paymentStatus Object payment status.
     * @param int|null        $clientsId Customer identificator.
     *
     * @return mixed
     */
    public function all(
        int $page = 1,
        DateTime|string $modifiedSince = '',
        DateTime|string $startDate = '',
        DateTime|string $endDate = '',
        string $status = '',
        string $paymentStatus = '',
        ?int $clientsId = null,
    ): mixed {
        $query = [];

        if ( $page !== 1 ) {
            $query['page'] = $page;
        }

        if ( $modifiedSince !== '' ) {
            $query['modified_since'] = ( $modifiedSince instanceof DateTime )
                ? $modifiedSince->format( \DateTimeInterface::ATOM )
                : $modifiedSince;
        }

        if ( $startDate !== '' ) {
            $query['start_date'] = ( $startDate instanceof DateTime )
                ? $startDate->format( 'Y-m-d' )
                : $startDate;
        }

        if ( $endDate !== '' ) {
            $query['end_date'] = ( $endDate instanceof DateTime )
                ? $endDate->format( 'Y-m-d' )
                : $endDate;
        }

        if ( $status !== '' ) {
            $query['status'] = $status;
        }

        if ( $paymentStatus !== '' ) {
            $query['payment_status'] = $paymentStatus;
        }

        if ( $clientsId !== null ) {
            $query['clients_id'] = $clientsId;
        }

        $response = $this->client->request( 'GET', 'sale_invoices', $query );

        return $response;
    }

    /**
     * Retrieve one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function get( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'sale_invoices/' . $id );

        return $response;
    }

    /**
     * Create a new sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-sale_invoices
     *
     * @param array<string,mixed>|array{
     *   "sale_invoice_type": "INVOICE",
     *   "cl_templates_id": 1,
     *   "clients_id": 126,
     *   "cl_countries_id": "EST",
     *   "number_suffix": "91",
     *   "create_date": "2016-02-15",
     *   "journal_date": "2016-02-15",
     *   "term_days": 30,
     *   "cl_currencies_id": "EUR",
     *   "show_client_balance": false
     * } $parameters
     *
     * @return mixed
     */
    public function create( array $parameters = [] ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'sale_invoice_type',
                    'cl_templates_id',
                    'clients_id',
                    'cl_countries_id',
                    'number_suffix',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
                    'show_client_balance',
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
            'sale_invoices',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Modify one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one
     *
     * @param int $id Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "sale_invoice_type": "INVOICE",
     *   "cl_templates_id": 1,
     *   "clients_id": 126,
     *   "cl_countries_id": "EST",
     *   "number_suffix": "91",
     *   "create_date": "2016-02-15",
     *   "journal_date": "2016-02-15",
     *   "term_days": 30,
     *   "cl_currencies_id": "EUR",
     *   "show_client_balance": false
     * } $parameters
     *
     * @return mixed
     */
    public function update( int $id, array $parameters ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'sale_invoice_type',
                    'cl_templates_id',
                    'clients_id',
                    'cl_countries_id',
                    'number_suffix',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
                    'show_client_balance',
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
            'PATCH',
            'sale_invoices/' . $id,
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function delete( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'sale_invoices/' . $id );

        return $response;
    }

    /**
     * Register one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_register
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function register( int $id ): mixed
    {
        $response = $this->client->request( 'PATCH', 'sale_invoices/' . $id . '/register' );

        return $response;
    }

    /**
     * Invalidate one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_invalidate
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function invalidate( int $id ): mixed
    {
        $response = $this->client->request( 'PATCH', 'sale_invoices/' . $id . '/invalidate' );

        return $response;
    }

    /**
     * Retrieve the system-generated XML e-invoice related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_xml
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function getXml( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'sale_invoices/' . $id . '/xml' );

        return $response;
    }

    /**
     * Retrieve the system-generated PDF related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_system
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function getSystemPdf( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'sale_invoices/' . $id . '/pdf_system' );

        return $response;
    }

    /**
     * Retrieve the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_user
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function getFile( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'sale_invoices/' . $id . '/document_user' );

        return $response;
    }

    /**
     * Update the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-sale_invoices_one_document_user
     *
     * @param int $id Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "name": string,
     *   "contents": string,
     * } $parameters Base64-encoded file payload.
     *
     * @return mixed
     */
    public function updateFile( int $id, array $parameters ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'name',
                    'contents',
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
            'PUT',
            'sale_invoices/' . $id . '/document_user',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one_document_user
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function deleteFile( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'sale_invoices/' . $id . '/document_user' );

        return $response;
    }

    /**
     * Retrieve delivery options for one specific sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_delivery_opts
     *
     * @param int $id Sale invoice identificator.
     *
     * @return mixed
     */
    public function getDeliveryOptions( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'sale_invoices/' . $id . '/delivery_options' );

        return $response;
    }

    /**
     * Send one specific sale invoice to the customer.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_deliver
     *
     * @param int $id Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "send_einvoice": bool,
     *   "send_email": bool,
     *   "email_addresses": string,
     *   "email_subject": string,
     *   "email_body": string,
     * } $parameters
     *
     * @return mixed
     */
    public function deliver( int $id, array $parameters ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'send_einvoice',
                    'send_email',
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
            'PATCH',
            'sale_invoices/' . $id . '/deliver',
            [],
            $parameters
        );

        return $response;
    }
}
