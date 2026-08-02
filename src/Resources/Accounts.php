<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\AccountsContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\Accounts\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class Accounts implements AccountsContract
{
    use Transportable;

    /**
     * Retrieve the account structure of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-accounts
     */
    public function all(): ListResponse
    {
        $payload = Payload::get('accounts');

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }
}
