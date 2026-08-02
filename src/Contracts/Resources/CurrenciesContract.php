<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\Currencies\ListResponse;

interface CurrenciesContract
{
    /**
     * Retrieve the active currencies of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-currencies
     */
    public function all(): ListResponse;
}
