<?php

namespace EFinancialsClient\API;

class PurchaseArticles extends AbstractAPI
{
    /**
     * Retrieve the purchase articles of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_articles
     */
    public function all(): mixed
    {

        $response = $this->client->request('GET', 'purchase_articles');

        return $response;
    }
}
