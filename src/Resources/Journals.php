<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class Journals
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
    ): mixed {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(\DateTimeInterface::ATOM)
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
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function get(int $id): mixed
    {
        $payload = Payload::get('journals/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Create a new journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-journals
     *
     * @param array<string,mixed>|array{
     *   "effective_date": "2014-05-31",
     *   "postings": array,
     *   "title": string,
     *   "clients_id": int,
     *   "cl_currencies_id": "EUR",
     *   "document_number": string,
     * } $parameters
     */
    public function create(array $parameters = []): mixed
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

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('journals', $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Modify one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     * @param array<string,mixed>|array{
     *   "effective_date": "2014-05-31",
     *   "postings": array,
     *   "title": string,
     *   "clients_id": int,
     *   "cl_currencies_id": "EUR",
     *   "document_number": string,
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed
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

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('journals/'.$id, $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function delete(int $id): mixed
    {
        $payload = Payload::delete('journals/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Register one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_register
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function register(int $id): mixed
    {
        $payload = Payload::patch('journals/'.$id.'/register');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Invalidate one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_invalidate
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function invalidate(int $id): mixed
    {
        $payload = Payload::patch('journals/'.$id.'/invalidate');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function getFile(int $id): mixed
    {
        $payload = Payload::get('journals/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Update the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     * @param array<string,mixed>|array{
     *   "name": string,
     *   "contents": string,
     * } $parameters Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): mixed
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

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::put('journals/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function deleteFile(int $id): mixed
    {
        $payload = Payload::delete('journals/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
