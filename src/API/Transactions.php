<?php

namespace EFinancialsClient\API;

use DateTime;

class Transactions extends AbstractAPI
{
    /**
     * Retrieve the transaction list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
     *
     * @param int             $page Page of responses to return.
     * @param DateTime|string $modifiedSince Return only objects modified since provided timestamp.
     * @param DateTime|string $startDate Date on given date or later.
     * @param DateTime|string $endDate Date on given date or before.
     * @param string          $status Object status.
     * @param string          $type Object type.
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
        string $type = '',
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

        if ( $type !== '' ) {
            $query['type'] = $type;
        }

        if ( $clientsId !== null ) {
            $query['clients_id'] = $clientsId;
        }

        $response = $this->client->request( 'GET', 'transactions', $query );

        return $response;
    }

    /**
     * Retrieve one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one
     *
     * @param int $id Transaction identificator.
     *
     * @return mixed
     */
    public function get( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'transactions/' . $id );

        return $response;
    }

    /**
     * Create a new transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-transactions
     *
     * @param array<string,mixed>|array{
     *   "accounts_dimensions_id": int,
     *   "type": "D"|"C",
     *   "amount": float,
     *   "cl_currencies_id": "EUR",
     *   "date": "2015-01-31",
     *   "description": string,
     *   "clients_id": int,
     * } $parameters
     *
     * @return mixed
     */
    public function create( array $parameters = [] ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'accounts_dimensions_id',
                    'type',
                    'amount',
                    'cl_currencies_id',
                    'date',
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
            'transactions',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Modify one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one
     *
     * @param int $id Transaction identificator.
     * @param array<string,mixed>|array{
     *   "accounts_dimensions_id": int,
     *   "type": "D"|"C",
     *   "amount": float,
     *   "cl_currencies_id": "EUR",
     *   "date": "2015-01-31",
     *   "description": string,
     *   "clients_id": int,
     * } $parameters
     *
     * @return mixed
     */
    public function update( int $id, array $parameters ): mixed
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'accounts_dimensions_id',
                    'type',
                    'amount',
                    'cl_currencies_id',
                    'date',
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
            'transactions/' . $id,
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one
     *
     * @param int $id Transaction identificator.
     *
     * @return mixed
     */
    public function delete( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'transactions/' . $id );

        return $response;
    }

    /**
     * Register one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_register
     *
     * @param int                  $id Transaction identificator.
     * @param array<int, mixed>    $distributions Optional transaction distribution rows.
     *
     * @return mixed
     */
    public function register( int $id, array $distributions = [] ): mixed
    {
        $response = $this->client->request(
            'PATCH',
            'transactions/' . $id . '/register',
            [],
            $distributions
        );

        return $response;
    }

    /**
     * Invalidate one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_invalidate
     *
     * @param int $id Transaction identificator.
     *
     * @return mixed
     */
    public function invalidate( int $id ): mixed
    {
        $response = $this->client->request( 'PATCH', 'transactions/' . $id . '/invalidate' );

        return $response;
    }

    /**
     * Retrieve the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one_document_user
     *
     * @param int $id Transaction identificator.
     *
     * @return mixed
     */
    public function getFile( int $id ): mixed
    {
        $response = $this->client->request( 'GET', 'transactions/' . $id . '/document_user' );

        return $response;
    }

    /**
     * Update the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-transactions_one_document_user
     *
     * @param int $id Transaction identificator.
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
            'transactions/' . $id . '/document_user',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one_document_user
     *
     * @param int $id Transaction identificator.
     *
     * @return mixed
     */
    public function deleteFile( int $id ): mixed
    {
        $response = $this->client->request( 'DELETE', 'transactions/' . $id . '/document_user' );

        return $response;
    }
}
