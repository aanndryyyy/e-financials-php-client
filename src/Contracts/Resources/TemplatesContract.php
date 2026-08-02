<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use EFinancialsClient\Responses\Templates\ListResponse;

interface TemplatesContract
{
    /**
     * Retrieve sale invoice templates of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-templates
     */
    public function all(): ListResponse;
}
