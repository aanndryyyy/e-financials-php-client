<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\JournalsContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Journals\JournalResponse;
use EFinancialsClient\Responses\Journals\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Journals implements JournalsContract
{
    use Transportable;

    /**
     * Retrieve the journal entry list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Effective date on given date or later.
     * @param  DateTime|string  $endDate  Effective date on given date or before.
     */
    public function all(
        int $page = 1,
        DateTime|string $modifiedSince = '',
        DateTime|string $startDate = '',
        DateTime|string $endDate = '',
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

        $payload = Payload::get('journals', $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Retrieve one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function get(int $id): JournalResponse
    {
        $payload = Payload::get('journals/'.$id);

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return JournalResponse::from($response->data());
    }

    /**
     * Create a new journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-journals
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'effective_date',
                    'postings',
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

        $payload = Payload::post('journals', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'effective_date',
                    'postings',
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

        $payload = Payload::patch('journals/'.$id, $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete('journals/'.$id);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Register one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_register
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function register(int $id): ApiResponse
    {
        $payload = Payload::patch('journals/'.$id.'/register');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Invalidate one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_invalidate
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function invalidate(int $id): ApiResponse
    {
        $payload = Payload::patch('journals/'.$id.'/invalidate');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function getFile(int $id): ApiFileResponse
    {
        $payload = Payload::get('journals/'.$id.'/document_user');

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Update the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
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

        $payload = Payload::put('journals/'.$id.'/document_user', $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function deleteFile(int $id): ApiResponse
    {
        $payload = Payload::delete('journals/'.$id.'/document_user');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
