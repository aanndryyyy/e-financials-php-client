<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\SalesArticlesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\SalesArticles\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class SalesArticles implements SalesArticlesContract
{
    use Transportable;

    /**
     * Retrieve the sale articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_articles
     */
    public function all(): ListResponse
    {
        $payload = Payload::get(ResourcePath::collection('sale_articles'));

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }
}
