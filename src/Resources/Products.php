<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\ProductsContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Products\ListResponse;
use EFinancialsClient\Responses\Products\ProductResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use InvalidArgumentException;

final class Products implements ProductsContract
{
    use Transportable;

    /**
     * Retrieve the product list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-products
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

        $payload = Payload::get('products', $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }

    /**
     * Get a product.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-products_one
     *
     * @param  int  $id  Product identificator.
     */
    public function get(int $id): ProductResponse
    {
        $payload = Payload::get('products/'.$id);

        /** @var Response<array<string, mixed>> $response */
        $response = $this->transporter->request($payload);

        return ProductResponse::from($response->data());
    }

    /**
     * Create a product.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-products
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(string $name, string $code, array $parameters = []): ApiResponse
    {
        $payload = Payload::post('products', array_merge([
            'name' => $name,
            'code' => $code,
        ], $parameters));

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Modify one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one
     *
     * @param  int  $id  Product identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters = []): ApiResponse
    {
        $missingRequiredParameters = array_diff_key(
            array_flip(
                [
                    'name',
                    'code',
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

        $payload = Payload::patch('products/'.$id, $parameters);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Delete one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-products_one
     *
     * @param  int  $id  Product identificator.
     */
    public function delete(int $id): ApiResponse
    {
        $payload = Payload::delete('products/'.$id);

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Deactivate one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one_deactivate
     *
     * @param  int  $id  Product identificator.
     */
    public function deactivate(int $id): ApiResponse
    {
        $payload = Payload::patch('products/'.$id.'/deactivate');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }

    /**
     * Reactivate one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one_reactivate
     *
     * @param  int  $id  Product identificator.
     */
    public function reactivate(int $id): ApiResponse
    {
        $payload = Payload::patch('products/'.$id.'/reactivate');

        /** @var Response<array{code: int, messages?: array<int, string>, created_object_id?: int|null}> $response */
        $response = $this->transporter->request($payload);

        return ApiResponse::from($response->data());
    }
}
