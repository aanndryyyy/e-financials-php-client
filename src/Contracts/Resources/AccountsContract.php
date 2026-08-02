<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\Accounts\ListResponse;

interface AccountsContract
{
    /**
     * Retrieve the account structure of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-accounts
     */
    public function all(): ListResponse;
}
