<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\InvoicesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Invoices\InvoiceInfoResponse;
use EFinancialsClient\Responses\Invoices\InvoiceSeriesResponse;
use EFinancialsClient\Responses\Invoices\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Invoices implements InvoicesContract
{
    use Transportable;

    /**
     * Retrieve the invoice series list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series
     */
    public function all(): ListResponse
    {
        $payload = Payload::get(ResourcePath::collection('invoice_series'));

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }

    /**
     * Retrieve one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
     */
    public function get(int $id): InvoiceSeriesResponse
    {
        $payload = Payload::get(ResourcePath::one('invoice_series', $id));

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->transporter->request($payload);

        return InvoiceSeriesResponse::from($response->data());
    }

    /**
     * Create a new invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-invoice_series
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'is_active',
                    'is_default',
                    'number_prefix',
                    'number_start_value',
                    'term_days',
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

        $payload = Payload::post(ResourcePath::collection('invoice_series'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_series_one
     *
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse
    {
        $missingParameters = array_diff_key(
            array_flip(
                [
                    'is_active',
                    'is_default',
                    'number_prefix',
                    'number_start_value',
                    'term_days',
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

        $payload = Payload::patch(ResourcePath::one('invoice_series', $id), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific invoice series of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-invoice_series_one
     *
     * @param  int  $id  Invoice series identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete(ResourcePath::one('invoice_series', $id));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Retrieve the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
     */
    public function allSettings(): InvoiceInfoResponse
    {
        $payload = Payload::get(ResourcePath::collection('invoice_info'));

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->transporter->request($payload);

        return InvoiceInfoResponse::from($response->data());
    }

    /**
     * Update the invoice settings of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-invoice_info
     *
     * @param  array<string, mixed>  $parameters
     */
    public function updateSettings(array $parameters): ApiResponse
    {
        $payload = Payload::patch(ResourcePath::collection('invoice_info'), $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
