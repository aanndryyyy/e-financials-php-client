<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\CurrenciesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\Currencies\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class Currencies implements CurrenciesContract
{
    use Transportable;

    /**
     * Retrieve the active currencies of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-currencies
     */
    public function all(): ListResponse
    {
        $payload = Payload::get(ResourcePath::collection('currencies'));

        /** @var Response<array<int, array{id: string, name_est?: string|null, name_eng?: string|null}>> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }
}
