<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Journals;

/**
 * OpenAPI `Journals` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class JournalResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 739,
        'parent_id' => null,
        'clients_id' => 172,
        'subclients_id' => null,
        'number' => 10008,
        'amendment_number' => 0,
        'title' => 'EMTA KMD alusel kanne nr 10008',
        'effective_date' => '2014-05-31',
        'registered' => true,
        'operations_id' => 21,
        'operation_type' => 'EMTA_VAT_DECLARATION',
        'document_number' => 'EMTA KMD 31.05.2014',
        'cl_currencies_id' => 'EUR',
        'currency_rate' => 1.0,
        'base_document_files_id' => null,
        'is_xls_imported' => false,
        'postings' => [
            PostingResponseFixture::ATTRIBUTES,
            [
                'id' => 8204,
                'journals_id' => null,
                'accounts_id' => 2510,
                'accounts_dimensions_id' => null,
                'type' => 'C',
                'amount' => 100.0,
                'base_amount' => 100.0,
                'cl_currencies_id' => 'EUR',
                'projects_project_id' => null,
                'projects_location_id' => null,
                'projects_person_id' => null,
                'is_deleted' => false,
            ],
        ],
        'insert_date' => '2014-06-20',
        'register_date' => '2014-10-29',
        'is_deleted' => false,
    ];
}
