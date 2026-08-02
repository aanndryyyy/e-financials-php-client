<?php

namespace EFinancialsClient\API;

class AccountDimensions extends AbstractAPI
{
    /**
     * Retrieve the account dimensions (subaccounts) of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-account_dimensions
     */
    public function all(): mixed
    {

        $response = $this->client->request('GET', 'account_dimensions');

        return $response;
    }
}
