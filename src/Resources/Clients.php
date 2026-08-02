<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Clients\ClientResponse;
use EFinancialsClient\Responses\Clients\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Clients
{
    use Transportable;

    /**
     * Get all the clients.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): ListResponse
    {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(DateTimeInterface::ATOM)
                : $modifiedSince;
        }

        $payload = Payload::get('clients', $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Get a client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-clients_one
     *
     * @param  int  $id  Client identificator.
     */
    public function get(int $id): ClientResponse
    {
        $payload = Payload::get('clients/'.$id);

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return ClientResponse::from($response->data());
    }

    /**
     * Create a new client of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-clients
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function create(array $parameters = []): ApiResponse
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

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('clients', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific client.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-clients_one
     *
     * @param  array<string, mixed>  $parameters  all request parameters.
     */
    public function update(int $id, array $parameters): ApiResponse
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

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('clients/'.$id, $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
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
        $payload = Payload::delete('clients/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
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
        $payload = Payload::patch('clients/'.$id.'/deactivate');
        $response = $this->transporter->request($payload);

        return $response->data();
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
        $payload = Payload::patch('clients/'.$id.'/reactivate');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
