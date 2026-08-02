<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\AccountDimensionsContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\AccountDimensions\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class AccountDimensions implements AccountDimensionsContract
{
    use Transportable;

    /**
     * Retrieve the account dimensions (subaccounts) of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-account_dimensions
     */
    public function all(): ListResponse
    {
        $payload = Payload::get(ResourcePath::collection('account_dimensions'));

        /** @var Response<array<int, array<array-key, mixed>>> $response */
        $response = $this->transporter->request($payload);

        /** @var array<int, array<array-key, mixed>> $data */
        $data = $response->data();

        return ListResponse::from($data);
    }
}
