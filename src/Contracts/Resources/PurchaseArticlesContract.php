<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\PurchaseArticles\ListResponse;

interface PurchaseArticlesContract
{
    /**
     * Retrieve the purchase articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_articles
     */
    public function all(): ListResponse;
}
