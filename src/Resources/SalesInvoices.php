<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\SalesInvoicesContract;
use EFinancialsClient\Enums\InvoiceStatus;
use EFinancialsClient\Enums\PaymentStatus;
use EFinancialsClient\Enums\SaleInvoiceType;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\SalesInvoices\ListResponse;
use EFinancialsClient\Responses\SalesInvoices\SaleInvoiceDeliveryOptionsResponse;
use EFinancialsClient\Responses\SalesInvoices\SaleInvoiceResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class SalesInvoices implements SalesInvoicesContract
{
    use Transportable;

    /**
     * Retrieve the sale invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Object revenue date on given date or later.
     * @param  DateTime|string  $endDate  Object revenue date on given date or before.
     * @param  InvoiceStatus|string  $status  Object status.
     * @param  PaymentStatus|string  $paymentStatus  Object payment status.
     * @param  int|null  $clientsId  Customer identificator.
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

        $payload = Payload::get(ResourcePath::collection('sale_invoices'), $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Retrieve one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function get(int $id): SaleInvoiceResponse
    {
        $payload = Payload::get(ResourcePath::one('sale_invoices', $id));

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return SaleInvoiceResponse::from($response->data());
    }

    /**
     * Create a new sale invoice of the specified company.
     *
     * `sale_invoice_type` accepts a {@see SaleInvoiceType}
     * case as well as a raw string; enums are unwrapped to their value when the
     * request is built.
     *
     * A credit invoice (kreeditarve) is created through this same endpoint:
     * pass `sale_invoice_type` as `SaleInvoiceType::CREDIT_INVOICE`, `credit_sale_invoices_id`
     * with the CONFIRMED original's id, the original's `number_suffix` (the server
     * derives the `K`-suffixed number itself) and negative `items[].amount` with a
     * positive `unit_net_price`. Any other `sale_invoice_type` combined with
     * `credit_sale_invoices_id` makes the API return HTTP 500.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-sale_invoices
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'sale_invoice_type',
                    'cl_templates_id',
                    'clients_id',
                    'cl_countries_id',
                    'number_suffix',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
                    'show_client_balance',
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

        $payload = Payload::post(ResourcePath::collection('sale_invoices'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific sale invoice of the specified company.
     *
     * `sale_invoice_type` accepts a {@see SaleInvoiceType} case as well as a raw string.
     *
     * Do not turn an existing invoice into a credit invoice by patching
     * `credit_sale_invoices_id` in here. The API accepts it and links the records,
     * but the invoice is still booked as an ordinary sale (D 1210 / C 1340, positive),
     * which adds to the receivable instead of clearing it. Create credit invoices
     * with `create()` instead.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'sale_invoice_type',
                    'cl_templates_id',
                    'clients_id',
                    'cl_countries_id',
                    'number_suffix',
                    'create_date',
                    'journal_date',
                    'term_days',
                    'cl_currencies_id',
                    'show_client_balance',
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

        $payload = Payload::patch(ResourcePath::one('sale_invoices', $id), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete(ResourcePath::one('sale_invoices', $id));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Register one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_register
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function register(int $id): ApiResponse
    {
        $payload = Payload::patch(ResourcePath::one('sale_invoices', $id, 'register'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Invalidate one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_invalidate
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function invalidate(int $id): ApiResponse
    {
        $payload = Payload::patch(ResourcePath::one('sale_invoices', $id, 'invalidate'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the system-generated XML e-invoice related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_xml
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getXml(int $id): ApiFileResponse
    {
        $payload = Payload::get(ResourcePath::one('sale_invoices', $id, 'xml'));

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Retrieve the system-generated PDF related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_system
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getSystemPdf(int $id): ApiFileResponse
    {
        $payload = Payload::get(ResourcePath::one('sale_invoices', $id, 'pdf_system'));

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Retrieve the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getFile(int $id): ApiFileResponse
    {
        $payload = Payload::get(ResourcePath::one('sale_invoices', $id, 'document_user'));

        /** @var Response<array{name: string, contents: string}> $response */
        $response = $this->transporter->request($payload);

        return ApiFileResponse::from($response->data());
    }

    /**
     * Update the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
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

        $payload = Payload::put(ResourcePath::one('sale_invoices', $id, 'document_user'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function deleteFile(int $id): ApiResponse
    {
        $payload = Payload::delete(ResourcePath::one('sale_invoices', $id, 'document_user'));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve delivery options for one specific sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_delivery_opts
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getDeliveryOptions(int $id): SaleInvoiceDeliveryOptionsResponse
    {
        $payload = Payload::get(ResourcePath::one('sale_invoices', $id, 'delivery_options'));

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return SaleInvoiceDeliveryOptionsResponse::from($response->data());
    }

    /**
     * Send one specific sale invoice to the customer.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_deliver
     *
     * @param  int  $id  Sale invoice identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function deliver(int $id, array $parameters): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'send_einvoice',
                    'send_email',
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

        $payload = Payload::patch(ResourcePath::one('sale_invoices', $id, 'deliver'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
