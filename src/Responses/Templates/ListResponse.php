<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Templates;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array<int, array{id: int, name: string, is_default: bool, cl_languages_id: string|null}>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, array{id: int, name: string, is_default: bool, cl_languages_id: string|null}>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, TemplateResponse>  $data
     */
    private function __construct(public readonly array $data)
    {
        // ..
    }

    /**
     * @param  array<int, array{id: int, name: string, is_default?: bool, cl_languages_id?: string|null}>  $attributes
     */
    public static function from(array $attributes): self
    {
        $data = array_map(
            static fn (array $item): TemplateResponse => TemplateResponse::from($item),
            array_values($attributes),
        );

        return new self($data);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_map(
            static fn (TemplateResponse $template): array => $template->toArray(),
            $this->data,
        );
    }
}
