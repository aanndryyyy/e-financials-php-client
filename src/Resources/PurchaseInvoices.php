<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\PurchaseInvoicesContract;
use EFinancialsClient\Enums\InvoiceStatus;
use EFinancialsClient\Enums\PaymentStatus;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\PurchaseInvoices\ListResponse;
use EFinancialsClient\Responses\PurchaseInvoices\PurchaseInvoiceResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

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
     * @param  InvoiceStatus|string  $status  Object status.
     * @param  PaymentStatus|string  $paymentStatus  Object payment status.
     * @param  int|null  $clientsId  Supplier identificator.
     */
    public function all(
        int $page = 1,
        DateTime|string $modifiedSince = '',
        DateTime|string $startDate = '',
        DateTime|string $endDate = '',
        InvoiceStatus|string $status = '',
        PaymentStatus|string $paymentStatus = '',
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

        if ($paymentStatus !== '') {
            $query['payment_status'] = $paymentStatus;
        }

        if ($clientsId !== null) {
            $query['clients_id'] = $clientsId;
        }

        $payload = Payload::get(ResourcePath::collection('purchase_invoices'), $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Retrieve one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function get(int $id): PurchaseInvoiceResponse
    {
        $payload = Payload::get(ResourcePath::one('purchase_invoices', $id));

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return PurchaseInvoiceResponse::from($response->data());
    }

    /**
     * Create a new purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-purchase_invoices
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
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

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::post(ResourcePath::collection('purchase_invoices'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
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

            throw new InvalidArgumentException(
                "Missing required parameter(s): $missingKeys"
            );
        }

        $payload = Payload::patch(ResourcePath::one('purchase_invoices', $id), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete(ResourcePath::one('purchase_invoices', $id));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Register one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_register
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function register(int $id): ApiResponse
    {
        $payload = Payload::patch(ResourcePath::one('purchase_invoices', $id, 'register'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Invalidate one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_invalidate
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function invalidate(int $id): ApiResponse
    {
        $payload = Payload::patch(ResourcePath::one('purchase_invoices', $id, 'invalidate'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function getFile(int $id): ApiFileResponse
    {
        $payload = Payload::get(ResourcePath::one('purchase_invoices', $id, 'document_user'));

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Update the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
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

        $payload = Payload::put(ResourcePath::one('purchase_invoices', $id, 'document_user'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function deleteFile(int $id): ApiResponse
    {
        $payload = Payload::delete(ResourcePath::one('purchase_invoices', $id, 'document_user'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
