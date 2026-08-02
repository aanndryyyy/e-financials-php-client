<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\PurchaseArticlesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\PurchaseArticles\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class PurchaseArticles implements PurchaseArticlesContract
{
    use Transportable;

    /**
     * Retrieve the purchase articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_articles
     */
    public function all(): ListResponse
    {
        $payload = Payload::get('purchase_articles');

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }
}
