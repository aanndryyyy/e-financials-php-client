<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class PurchaseArticles
{
    use Transportable;

    /**
     * Retrieve the purchase articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_articles
     */
    public function all(): mixed
    {

        $payload = Payload::get('purchase_articles');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
