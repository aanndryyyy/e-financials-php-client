<?php

declare(strict_types=1);

namespace Tests\Fakes;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Queue-based PSR-18 client for unit tests.
 */
final class HttpClientFake implements ClientInterface
{
    /**
     * @param  list<ResponseInterface>  $queue
     */
    public function __construct(private array $queue = []) {}

    /**
     * @param  list<ResponseInterface>  $responses
     */
    public static function sequence(array $responses): self
    {
        return new self(array_values($responses));
    }

    /**
     * @param  array<array-key, mixed>|string  $body
     * @param  array<string, string|array<int, string>>  $headers
     */
    public static function response(
        int $status = 200,
        array|string $body = '',
        array $headers = [],
    ): ResponseInterface {
        if (is_array($body)) {
            $body = json_encode($body, JSON_THROW_ON_ERROR);
            $headers += ['Content-Type' => 'application/json'];
        }

        return new Response($status, $headers, $body);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = array_shift($this->queue);

        if (! $response instanceof ResponseInterface) {
            throw new RuntimeException('HttpClientFake has no more queued responses.');
        }

        return $response;
    }
}
