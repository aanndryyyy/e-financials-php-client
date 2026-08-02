<?php

namespace EFinancialsClient\API;

class Templates extends AbstractAPI
{
    /**
     * Retrieve the sale invoice templates of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-templates
     */
    public function all(): mixed
    {
        $response = $this->client->request('GET', 'templates');

        return $response;
    }
}
