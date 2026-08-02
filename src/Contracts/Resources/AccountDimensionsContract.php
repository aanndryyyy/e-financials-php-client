<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\AccountDimensions\ListResponse;

interface AccountDimensionsContract
{
    /**
     * Retrieve the account dimensions (subaccounts) of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-account_dimensions
     */
    public function all(): ListResponse;
}
