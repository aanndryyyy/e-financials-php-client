<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\SalesArticles\ListResponse;

interface SalesArticlesContract
{
    /**
     * Retrieve the sale articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_articles
     */
    public function all(): ListResponse;
}
