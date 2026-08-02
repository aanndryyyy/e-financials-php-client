<?php

namespace EFinancialsClient\API;

class Currencies extends AbstractAPI
{
    /**
     * Retrieve the active currencies of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-currencies
     */
    public function all(): mixed
    {

        $response = $this->client->request('GET', 'currencies');

        return $response;
    }
}
