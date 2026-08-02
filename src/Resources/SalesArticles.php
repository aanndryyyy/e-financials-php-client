<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class SalesArticles
{
    use Transportable;

    /**
     * Retrieve the sale articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_articles
     */
    public function all(): mixed
    {

        $payload = Payload::get('sale_articles');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
