<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Journals;

/**
 * OpenAPI `Postings` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class PostingResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 8203,
        'journals_id' => null,
        'accounts_id' => 2511,
        'accounts_dimensions_id' => null,
        'type' => 'D',
        'amount' => 100.0,
        'base_amount' => 100.0,
        'cl_currencies_id' => 'EUR',
        'projects_project_id' => null,
        'projects_location_id' => null,
        'projects_person_id' => null,
        'is_deleted' => false,
    ];
}
