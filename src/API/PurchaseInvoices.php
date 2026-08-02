<?php

namespace EFinancialsClient\API;

use DateTime;

class PurchaseInvoices extends AbstractAPI
{
    /**
     * Retrieve the purchase invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices
     *
     * @param int             $page Page of responses to return.
     * @param DateTime|string $modifiedSince Return only objects modified since provided timestamp.
     * @param DateTime|string $startDate Object created on given date or later.
     * @param DateTime|string $endDate Object created on given date or before.
     * @param string          $status Object status.
     * @param string          $paymentStatus Object payment status.
     * @param int|null        $clientsId Supplier identificator.
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

        $response = $this->client->request( 'GET', 'purchase_invoices', $query );

        return $response;
    }

    /**
     * Retrieve one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function get( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'purchase_invoices/' . $id );

        return $response;
    }

    /**
     * Create a new purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-purchase_invoices
     *
     * @param array<string,mixed>|array{
     *   "clients_id": 803,
     *   "client_name": string,
     *   "number": string,
     *   "create_date": "2017-08-09",
     *   "journal_date": "2017-08-09",
     *   "term_days": 0,
     *   "cl_currencies_id": "EUR"
     * } $parameters
     *
     * @return mixed
     */
    public function create( array $parameters = [] ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'clients_id',
                    'client_name',
                    'number',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
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
            'purchase_invoices',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Modify one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one
     *
     * @param int $id Purchase invoice identificator.
     * @param array<string,mixed>|array{
     *   "clients_id": 803,
     *   "client_name": string,
     *   "number": string,
     *   "create_date": "2017-08-09",
     *   "journal_date": "2017-08-09",
     *   "term_days": 0,
     *   "cl_currencies_id": "EUR"
     * } $parameters
     *
     * @return mixed
     */
    public function update( int $id, array $parameters ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'clients_id',
                    'client_name',
                    'number',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
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
            'purchase_invoices/' . $id,
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function delete( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'purchase_invoices/' . $id );

        return $response;
    }

    /**
     * Register one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_register
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function register( int $id ): mixed
    {
        $response = $this->client->request( 'PATCH', 'purchase_invoices/' . $id . '/register' );

        return $response;
    }

    /**
     * Invalidate one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_invalidate
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function invalidate( int $id ): mixed
    {
        $response = $this->client->request( 'PATCH', 'purchase_invoices/' . $id . '/invalidate' );

        return $response;
    }

    /**
     * Retrieve the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one_document_user
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function getFile( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'purchase_invoices/' . $id . '/document_user' );

        return $response;
    }

    /**
     * Update the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-purchase_invoices_one_document_user
     *
     * @param int $id Purchase invoice identificator.
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
            'purchase_invoices/' . $id . '/document_user',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one_document_user
     *
     * @param int $id Purchase invoice identificator.
     *
     * @return mixed
     */
    public function deleteFile( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'purchase_invoices/' . $id . '/document_user' );

        return $response;
    }
}
