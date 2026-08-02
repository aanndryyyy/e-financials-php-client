<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class AccountDimensions
{
    use Transportable;

    /**
     * Retrieve the account dimensions (subaccounts) of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-account_dimensions
     */
    public function all(): mixed
    {

        $payload = Payload::get('account_dimensions');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
