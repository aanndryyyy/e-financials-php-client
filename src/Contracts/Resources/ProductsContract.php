<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Products\ListResponse;
use EFinancialsClient\Responses\Products\ProductResponse;

interface ProductsContract
{
    /**
     * Retrieve the product list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-products
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): ListResponse;

    /**
     * Get a product.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-products_one
     *
     * @param  int  $id  Product identificator.
     */
    public function get(int $id): ProductResponse;

    /**
     * Create a product.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-products
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(string $name, string $code, array $parameters = []): ApiResponse;

    /**
     * Modify one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one
     *
     * @param  int  $id  Product identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters = []): ApiResponse;

    /**
     * Delete one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-products_one
     *
     * @param  int  $id  Product identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Deactivate one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one_deactivate
     *
     * @param  int  $id  Product identificator.
     */
    public function deactivate(int $id): ApiResponse;

    /**
     * Reactivate one specific product of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-products_one_reactivate
     *
     * @param  int  $id  Product identificator.
     */
    public function reactivate(int $id): ApiResponse;
}
