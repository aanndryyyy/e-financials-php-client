<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\CostProfitCentres;

/**
 * OpenAPI `Projects` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class CostProfitCentreResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 12,
        'parent_id' => 11,
        'name' => 'Elekter',
        'notes' => null,
        'cl_projects_type' => 'PROJECT',
        'is_disabled' => false,
        'create_date' => '2014-06-18',
        'deprecated_parent_id' => 11,
        'is_deleted' => false,
    ];
}
