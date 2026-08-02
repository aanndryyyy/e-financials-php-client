<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects\Transporter;

/**
 * @internal
 */
final class Headers
{
    /**
     * @param  array<string, string>  $headers
     */
    private function __construct(private readonly array $headers)
    {
        // ..
    }

    public static function create(): self
    {
        return new self([]);
    }

    public function withCustomHeader(string $name, string $value): self
    {
        return new self([
            ...$this->headers,
            $name => $value,
        ]);
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
