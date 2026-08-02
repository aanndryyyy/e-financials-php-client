<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Contracts\TransporterContract;
use EFinancialsClient\Testing\Exceptions\NoFakeResponsesException;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use JsonException;
use Throwable;

/**
 * @internal
 */
final class TransporterFake implements TransporterContract
{
    /**
     * @var array<int, Payload>
     */
    private array $recorded = [];

    /**
     * @var array<int, array{0: Payload, 1: Response}>
     */
    private array $recordedPairs = [];

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function __construct(private array $responses = []) {}

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function addResponses(array $responses): void
    {
        $this->responses = [...$this->responses, ...$responses];
    }

    /**
     * @return array<int, Payload>
     */
    public function recorded(): array
    {
        return $this->recorded;
    }

    /**
     * @return array<int, array{0: Payload, 1: Response}>
     */
    public function recordedPairs(): array
    {
        return $this->recordedPairs;
    }

    /**
     * {@inheritDoc}
     *
     * @throws NoFakeResponsesException
     * @throws JsonException
     * @throws Throwable
     */
    public function request(Payload $payload): Response
    {
        $this->recorded[] = $payload;

        $response = array_shift($this->responses);

        if ($response === null) {
            throw new NoFakeResponsesException;
        }

        if ($response instanceof Throwable) {
            throw $response;
        }

        $resolved = $this->resolve($response);
        $this->recordedPairs[] = [$payload, $resolved];

        return $resolved;
    }

    /**
     * @param  ResponseContract|array<array-key, mixed>|string  $response
     *
     * @throws JsonException
     */
    private function resolve(ResponseContract|array|string $response): Response
    {
        if ($response instanceof ResponseContract) {
            return Response::from($response->toArray());
        }

        if (is_string($response)) {
            /** @var array<array-key, mixed> $decoded */
            $decoded = json_decode($response, true, flags: JSON_THROW_ON_ERROR);

            return Response::from($decoded);
        }

        return Response::from($response);
    }
}
