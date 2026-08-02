<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\ValueObjects\Transporter\Payload;

final class Accounts
{
    use Transportable;

    /**
     * Retrieve the account structure of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-accounts
     */
    public function all(): mixed
    {

        $payload = Payload::get('accounts');
        $response = $this->transporter->request($payload);

        return $response->data();
    }
}
