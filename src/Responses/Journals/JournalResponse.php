<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Journals;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Journals` schema, plus example-backed fields
 * (`insert_date`, `register_date`, `is_deleted`).
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one
 *
 * @phpstan-import-type PostingData from PostingResponse
 *
 * @phpstan-type JournalData array{
 *     id: int|null,
 *     parent_id: int|null,
 *     clients_id: int|null,
 *     subclients_id: int|null,
 *     number: int|null,
 *     amendment_number: int|null,
 *     title: string|null,
 *     effective_date: string|null,
 *     registered: bool|null,
 *     operations_id: int|null,
 *     operation_type: string|null,
 *     document_number: string|null,
 *     cl_currencies_id: string|null,
 *     currency_rate: float|null,
 *     base_document_files_id: int|null,
 *     is_xls_imported: bool|null,
 *     postings: array<int, PostingData>,
 *     insert_date: string|null,
 *     register_date: string|null,
 *     is_deleted: bool|null
 * }
 *
 * @implements ResponseContract<JournalData>
 */
final class JournalResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<JournalData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, PostingResponse>  $postings
     */
    private function __construct(
        public readonly ?int $id,
        public readonly ?int $parentId,
        public readonly ?int $clientsId,
        public readonly ?int $subclientsId,
        public readonly ?int $number,
        public readonly ?int $amendmentNumber,
        public readonly ?string $title,
        public readonly ?string $effectiveDate,
        public readonly ?bool $registered,
        public readonly ?int $operationsId,
        public readonly ?string $operationType,
        public readonly ?string $documentNumber,
        public readonly ?string $clCurrenciesId,
        public readonly ?float $currencyRate,
        public readonly ?int $baseDocumentFilesId,
        public readonly ?bool $isXlsImported,
        public readonly array $postings,
        public readonly ?string $insertDate,
        public readonly ?string $registerDate,
        public readonly ?bool $isDeleted,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<int, array<string, mixed>> $rawPostings */
        $rawPostings = is_array($attributes['postings'] ?? null) ? $attributes['postings'] : [];

        $postings = array_values(array_map(
            static fn (array $posting): PostingResponse => PostingResponse::from($posting),
            $rawPostings,
        ));

        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['parent_id'] ?? null),
            self::intOrNull($attributes['clients_id'] ?? null),
            self::intOrNull($attributes['subclients_id'] ?? null),
            self::intOrNull($attributes['number'] ?? null),
            self::intOrNull($attributes['amendment_number'] ?? null),
            self::stringOrNull($attributes['title'] ?? null),
            self::stringOrNull($attributes['effective_date'] ?? null),
            self::boolOrNull($attributes['registered'] ?? null),
            self::intOrNull($attributes['operations_id'] ?? null),
            self::stringOrNull($attributes['operation_type'] ?? null),
            self::stringOrNull($attributes['document_number'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::floatOrNull($attributes['currency_rate'] ?? null),
            self::intOrNull($attributes['base_document_files_id'] ?? null),
            self::boolOrNull($attributes['is_xls_imported'] ?? null),
            $postings,
            self::stringOrNull($attributes['insert_date'] ?? null),
            self::stringOrNull($attributes['register_date'] ?? null),
            self::boolOrNull($attributes['is_deleted'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'clients_id' => $this->clientsId,
            'subclients_id' => $this->subclientsId,
            'number' => $this->number,
            'amendment_number' => $this->amendmentNumber,
            'title' => $this->title,
            'effective_date' => $this->effectiveDate,
            'registered' => $this->registered,
            'operations_id' => $this->operationsId,
            'operation_type' => $this->operationType,
            'document_number' => $this->documentNumber,
            'cl_currencies_id' => $this->clCurrenciesId,
            'currency_rate' => $this->currencyRate,
            'base_document_files_id' => $this->baseDocumentFilesId,
            'is_xls_imported' => $this->isXlsImported,
            'postings' => array_map(
                static fn (PostingResponse $posting): array => $posting->toArray(),
                $this->postings,
            ),
            'insert_date' => $this->insertDate,
            'register_date' => $this->registerDate,
            'is_deleted' => $this->isDeleted,
        ];
    }
}
