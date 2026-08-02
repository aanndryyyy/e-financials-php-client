<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects\Transporter;

/**
 * @template TData of array
 *
 * @internal
 */
final readonly class Response
{
    /**
     * @param  TData  $data
     */
    private function __construct(private array $data)
    {
        // ..
    }

    /**
     * @param  TData  $data
     * @return Response<TData>
     */
    public static function from(array $data): self
    {
        return new self($data);
    }

    /**
     * @return TData
     */
    public function data(): array
    {
        return $this->data;
    }
}
