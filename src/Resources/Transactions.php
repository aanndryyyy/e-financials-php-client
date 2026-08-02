<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\TransactionsContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Transactions\ListResponse;
use EFinancialsClient\Responses\Transactions\TransactionResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Transactions implements TransactionsContract
{
    use Transportable;

    /**
     * Retrieve the transaction list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Date on given date or later.
     * @param  DateTime|string  $endDate  Date on given date or before.
     * @param  string  $status  Object status.
     * @param  string  $type  Object type.
     * @param  int|null  $clientsId  Customer identificator.
     */
    public function all(
        int $page = 1,
        DateTime|string $modifiedSince = '',
        DateTime|string $startDate = '',
        DateTime|string $endDate = '',
        string $status = '',
        string $type = '',
        ?int $clientsId = null,
    ): ListResponse {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(DateTimeInterface::ATOM)
                : $modifiedSince;
        }

        if ($startDate !== '') {
            $query['start_date'] = ($startDate instanceof DateTime)
                ? $startDate->format('Y-m-d')
                : $startDate;
        }

        if ($endDate !== '') {
            $query['end_date'] = ($endDate instanceof DateTime)
                ? $endDate->format('Y-m-d')
                : $endDate;
        }

        if ($status !== '') {
            $query['status'] = $status;
        }

        if ($type !== '') {
            $query['type'] = $type;
        }

        if ($clientsId !== null) {
            $query['clients_id'] = $clientsId;
        }

        $payload = Payload::get('transactions', $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Retrieve one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function get(int $id): TransactionResponse
    {
        $payload = Payload::get('transactions/'.$id);

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return TransactionResponse::from($response->data());
    }

    /**
     * Create a new transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-transactions
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
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

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('transactions', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
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

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('transactions/'.$id, $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete('transactions/'.$id);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Register one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_register
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<int, mixed>  $distributions  Optional transaction distribution rows.
     */
    public function register(int $id, array $distributions = []): ApiResponse
    {
        $payload = Payload::patch('transactions/'.$id.'/register', $distributions);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Invalidate one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_invalidate
     *
     * @param  int  $id  Transaction identificator.
     */
    public function invalidate(int $id): ApiResponse
    {
        $payload = Payload::patch('transactions/'.$id.'/invalidate');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function getFile(int $id): ApiFileResponse
    {
        $payload = Payload::get('transactions/'.$id.'/document_user');

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Update the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<string, mixed>  $parameters  Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): ApiResponse
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

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::put('transactions/'.$id.'/document_user', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function deleteFile(int $id): ApiResponse
    {
        $payload = Payload::delete('transactions/'.$id.'/document_user');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
