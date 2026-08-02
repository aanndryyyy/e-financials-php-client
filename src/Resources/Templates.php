<?php

declare(strict_types=1);

namespace EFinancialsClient\Resources;

use EFinancialsClient\Contracts\Resources\TemplatesContract;
use EFinancialsClient\Resources\Concerns\Transportable;
use EFinancialsClient\Responses\Templates\ListResponse;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;

final class Templates implements TemplatesContract
{
    use Transportable;

    /**
     * Retrieve sale invoice templates of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-templates
     */
    public function all(): ListResponse
    {
        $payload = Payload::get('templates');

        /** @var Response<array<int, array{id: int, name: string, is_default?: bool, cl_languages_id?: string|null}>> $response */
        $response = $this->transporter->request($payload);

        return ListResponse::from($response->data());
    }
}
