<?php

declare(strict_types=1);

namespace Tests\Fixtures\Responses;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{ok: bool}>
 */
final class MissingFixtureResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{ok: bool}>
     */
    use ArrayAccessible;

    use Fakeable;

    private function __construct(public readonly bool $ok) {}

    /**
     * @param  array{ok?: bool}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self((bool) ($attributes['ok'] ?? false));
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['ok' => $this->ok];
    }
}
