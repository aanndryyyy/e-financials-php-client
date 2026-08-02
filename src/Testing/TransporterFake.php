<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Contracts\TransporterContract;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use Exception;
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
     * {@inheritDoc}
     */
    public function request(Payload $payload): Response
    {
        $this->recorded[] = $payload;

        $response = array_shift($this->responses);

        if ($response === null) {
            throw new Exception('No fake responses left.');
        }

        if ($response instanceof Throwable) {
            throw $response;
        }

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

    /**
     * {@inheritDoc}
     */
    public function requestContent(Payload $payload): string
    {
        $response = $this->request($payload);

        return json_encode($response->data(), JSON_THROW_ON_ERROR);
    }
}
