<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Journals;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Postings` schema, plus example-backed `is_deleted`.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type PostingData array{
 *     id: int|null,
 *     journals_id: int|null,
 *     accounts_id: int|null,
 *     accounts_dimensions_id: int|null,
 *     type: string|null,
 *     amount: float|null,
 *     base_amount: float|null,
 *     cl_currencies_id: string|null,
 *     projects_project_id: int|null,
 *     projects_location_id: int|null,
 *     projects_person_id: int|null,
 *     is_deleted: bool|null
 * }
 *
 * @implements ResponseContract<PostingData>
 */
final class PostingResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<PostingData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly ?int $journalsId,
        public readonly ?int $accountsId,
        public readonly ?int $accountsDimensionsId,
        public readonly ?string $type,
        public readonly ?float $amount,
        public readonly ?float $baseAmount,
        public readonly ?string $clCurrenciesId,
        public readonly ?int $projectsProjectId,
        public readonly ?int $projectsLocationId,
        public readonly ?int $projectsPersonId,
        public readonly ?bool $isDeleted,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['journals_id'] ?? null),
            self::intOrNull($attributes['accounts_id'] ?? null),
            self::intOrNull($attributes['accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['type'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
            self::floatOrNull($attributes['base_amount'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::intOrNull($attributes['projects_project_id'] ?? null),
            self::intOrNull($attributes['projects_location_id'] ?? null),
            self::intOrNull($attributes['projects_person_id'] ?? null),
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
            'journals_id' => $this->journalsId,
            'accounts_id' => $this->accountsId,
            'accounts_dimensions_id' => $this->accountsDimensionsId,
            'type' => $this->type,
            'amount' => $this->amount,
            'base_amount' => $this->baseAmount,
            'cl_currencies_id' => $this->clCurrenciesId,
            'projects_project_id' => $this->projectsProjectId,
            'projects_location_id' => $this->projectsLocationId,
            'projects_person_id' => $this->projectsPersonId,
            'is_deleted' => $this->isDeleted,
        ];
    }
}
