<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use DateTime;
use DateTimeInterface;
use EFinancialsClient\Contracts\Resources\CostProfitCentresContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\CostProfitCentres\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\ResourcePath;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class CostProfitCentres implements CostProfitCentresContract
{
    use Transportable;

    /**
     * Retrieve the cost/profit centres list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-projects
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = ''): ListResponse
    {
        $query = [];

        if ($page !== 1) {
            $query['page'] = $page;
        }

        if ($modifiedSince !== '') {
            $query['modified_since'] = ($modifiedSince instanceof DateTime)
                ? $modifiedSince->format(DateTimeInterface::ATOM)
                : $modifiedSince;
        }

        $payload = Payload::get(ResourcePath::collection('projects'), $query);

        /** @var Response<array{current_page: int, total_pages: int, items: array<int, array<array-key, mixed>>}> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }
}
