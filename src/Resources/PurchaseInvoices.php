<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use EFinancialsClient\Contracts\Resources\PurchaseInvoicesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class PurchaseInvoices implements PurchaseInvoicesContract
{
    use Transportable;

    /**
     * Retrieve the purchase invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Object created on given date or later.
     * @param  DateTime|string  $endDate  Object created on given date or before.
     * @param  string  $status  Object status.
     * @param  string  $paymentStatus  Object payment status.
     * @param  int|null  $clientsId  Supplier identificator.
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

        if ($status !== '') {
            $query['status'] = $status;
        }

        if ($paymentStatus !== '') {
            $query['payment_status'] = $paymentStatus;
        }

        if ($clientsId !== null) {
            $query['clients_id'] = $clientsId;
        }

        $payload = Payload::get('purchase_invoices', $query);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function get(int $id): mixed
    {
        $payload = Payload::get('purchase_invoices/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
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
     */
    public function create(array $parameters = []): mixed
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

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post('purchase_invoices', $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Modify one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     * @param array<string,mixed>|array{
     *   "clients_id": 803,
     *   "client_name": string,
     *   "number": string,
     *   "create_date": "2017-08-09",
     *   "journal_date": "2017-08-09",
     *   "term_days": 0,
     *   "cl_currencies_id": "EUR"
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed
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

        if (count($missingRequiredParameters) !== 0) {
            $missingKeys = implode(', ', array_keys($missingRequiredParameters));

            throw new \InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch('purchase_invoices/'.$id, $parameters);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function delete(int $id): mixed
    {
        $payload = Payload::delete('purchase_invoices/'.$id);
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Register one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_register
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function register(int $id): mixed
    {
        $payload = Payload::patch('purchase_invoices/'.$id.'/register');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Invalidate one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_invalidate
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function invalidate(int $id): mixed
    {
        $payload = Payload::patch('purchase_invoices/'.$id.'/invalidate');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Retrieve the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function getFile(int $id): mixed
    {
        $payload = Payload::get('purchase_invoices/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Update the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
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

        $payload = Payload::put('purchase_invoices/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }

    /**
     * Delete the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function deleteFile(int $id): mixed
    {
        $payload = Payload::delete('purchase_invoices/'.$id.'/document_user');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
