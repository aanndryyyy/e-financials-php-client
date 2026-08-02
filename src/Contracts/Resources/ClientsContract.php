<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Clients\ClientResponse;
use EFinancialsClient\Responses\Clients\ListResponse;

interface ClientsContract
{
    /**
     * Get all the clients.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): ListResponse;

    /**
     * Get a client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients_one
     *
     * @param  int  $id  Client identificator.
     */
    public function get(int $id): ClientResponse;

    /**
     * Create a new client of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-clients
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific Client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-clients_one
     *
     * @param  int  $id  Client identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Deactivate one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one_deactivate
     *
     * @param  int  $id  Client identificator.
     */
    public function deactivate(int $id): ApiResponse;

    /**
     * Reactivate one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one_reactivate
     *
     * @param  int  $id  Client identificator.
     */
    public function reactivate(int $id): ApiResponse;
}
