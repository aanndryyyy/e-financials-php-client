<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Responses\CostProfitCentres\ListResponse;

interface CostProfitCentresContract
{
    /**
     * Retrieve the cost/profit centres list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-projects
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): ListResponse;
}
