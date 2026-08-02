<?php

namespace EFinancialsClient\API;

class Accounts extends AbstractAPI
{
    /**
     * Retrieve the account structure of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-accounts
     */
    public function all(): mixed
    {

        $response = $this->client->request('GET', 'accounts');

        return $response;
    }
}
