<?php

namespace EFinancialsClient\API;

use DateTime;

class CostProfitCentres extends AbstractAPI
{
    /**
     * Retrieve the cost/profit centres list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-projects
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): mixed
    {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(\DateTimeInterface::ATOM)
                : $modifiedSince;
        }

        $response = $this->client->request('GET', 'projects', $query);

        return $response;
    }
}
