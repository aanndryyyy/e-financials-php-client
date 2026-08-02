<?php

namespace EFinancialsClient\API;

use DateTime;

class Clients extends AbstractAPI
{
    /**
     * Get all the clients.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): mixed
    {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            // If $modifiedSince is a DateTime object, format it as an Atom string
            // Otherwise, assign keep it as date string.
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(\DateTimeInterface::ATOM)
                : $modifiedSince;
        }

        $response = $this->client->request('GET', 'clients', $query);

        return $response;
    }

    /**
     * Get a client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients_one
     *
     * @param  int  $id  Client identificator.
     */
    public function get(int $id): mixed
    {
        $response = $this->client->request('GET', 'clients/'.$id);

        return $response;
    }

    /**
     * Create a new client of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-clients
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function create(array $parameters = []): mixed
    {

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
            $parameters
        );

        if (count($missingParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingParameters));

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $response = $this->client->request(
            'POST',
            'clients',
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Modify one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function update(int $id, array $parameters): mixed
    {

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
            'clients/'.$id,
            [],
            $parameters
        );

        return $response;
    }

    /**
     * Delete one specific Client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-clients_one
     *
     * @param  int  $id  Client identificator.
     */
    public function delete(int $id): mixed
    {
        $response = $this->client->request('DELETE', 'clients/'.$id);

        return $response;
    }

    /**
     * Deactivate one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one_deactivate
     *
     * @param  int  $id  Client identificator.
     */
    public function deactivate(int $id): mixed
    {
        $response = $this->client->request('PATCH', 'clients/'.$id.'/deactivate');

        return $response;
    }

    /**
     * Reactivate one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one_reactivate
     *
     * @param  int  $id  Client identificator.
     */
    public function reactivate(int $id): mixed
    {
        $response = $this->client->request('PATCH', 'clients/'.$id.'/reactivate');

        return $response;
    }
}
