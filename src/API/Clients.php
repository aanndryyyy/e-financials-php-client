<?php

namespace EFinancialsClient\API;

use DateTime;

class Clients extends AbstractAPI
{
    /**
     * Get the clients.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients e-Financials API
     *
     * @param int             $page Page of responses to return.
     * @param DateTime|string $modifiedSince Return only objects modified since provided timestamp.
     *
     * @return mixed
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): mixed
    {
        $query = [];

        if ( $page !== 1 ) {
            $query['page'] = $page;
        }

        if ( $modifiedSince !== '' ) {
            // If $modifiedSince is a DateTime object, format it as an Atom string
            // Otherwise, assign keep it as date string.
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format( \DateTimeInterface::ATOM )
                : $modifiedSince;
        }

        $response = $this->client->request( 'GET', 'clients', $query );

        return $response;
    }

    /**
    * Create a new client of the specified company.
    *
    * @see https://rmp-api.rik.ee/api.html#operation/post-clients
    *
    * @param array<string, mixed> $requiredParameters required request parameters.
    * @param array<string, mixed> $parameters additional request parameters.
    *
    * @return mixed
    */
    public function create(
        array $requiredParameters,
        array $parameters = []
    ): mixed {

        $missingParameters = array_diff_key(
            array_flip(
                [
                    'is_client',
                    'is_supplier',
                    'name',
                    'cl_code_country',
                    'is_member',
                    'send_invoice_to_email',
                    'send_invoice_to_accounting_email',
                ]
            ),
            $requiredParameters
        );

        if ( count( $missingParameters ) !== 0 ) {
            $missingKeys = implode( ', ', array_keys( $missingParameters ) );

            return [
                'internal_error' => "Missing required parameter(s): $missingKeys",
            ];
        }

        return $this->client->request( 'POST', 'clients', [], array_merge( $requiredParameters, $parameters ) );
    }
}