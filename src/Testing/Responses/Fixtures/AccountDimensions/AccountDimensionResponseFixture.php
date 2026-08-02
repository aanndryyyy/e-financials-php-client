<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\AccountDimensions;

/**
 * OpenAPI `AccountsDimensions` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class AccountDimensionResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 1,
        'accounts_id' => 1100,
        'title_est' => 'Lühiajalised finantsinvesteeringud',
        'title_eng' => 'Current financial investments',
        'cl_currencies_id' => 'EUR',
        'is_deleted' => false,
        'expenditure_accounts_dimensions_id' => null,
        'amortization_accounts_dimensions_id' => null,
    ];
}
