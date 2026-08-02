<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects\Transporter;

use EFinancialsClient\Enums\Transporter\Method;
use EFinancialsClient\ValueObjects\ApiCredentials;
use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
final class Payload
{
    /**
     * @param  array<string, mixed>  $query
     * @param  array<array-key, mixed>  $body
     */
    private function __construct(
        private readonly Method $method,
        private readonly string $resource,
        private readonly array $query = [],
        private readonly array $body = [],
    ) {
        // ..
    }

    /**
     * @param  array<string, mixed>  $query
     */
    public static function get(string $resource, array $query = []): self
    {
        return new self(Method::GET, $resource, $query);
    }

    /**
     * @param  array<array-key, mixed>  $body
     */
    public static function post(string $resource, array $body = []): self
    {
        return new self(Method::POST, $resource, body: $body);
    }

    /**
     * @param  array<array-key, mixed>  $body
     */
    public static function patch(string $resource, array $body = []): self
    {
        return new self(Method::PATCH, $resource, body: $body);
    }

    /**
     * @param  array<array-key, mixed>  $body
     */
    public static function put(string $resource, array $body = []): self
    {
        return new self(Method::PUT, $resource, body: $body);
    }

    public static function delete(string $resource): self
    {
        return new self(Method::DELETE, $resource);
    }

    public function method(): Method
    {
        return $this->method;
    }

    public function resource(): string
    {
        return $this->resource;
    }

    /**
     * @return array<string, mixed>
     */
    public function query(): array
    {
        return $this->query;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function body(): array
    {
        return $this->body;
    }

    /**
     * Creates a new PSR-7 request with e-Financials auth headers.
     */
    public function toRequest(BaseUri $baseUri, Headers $headers, ApiCredentials $credentials): RequestInterface
    {
        $psr17Factory = new Psr17Factory;

        $resourcePath = ltrim($this->resource, '/');
        $signedPath = $baseUri->signedPath($resourcePath);
        $uri = $baseUri->toString().$resourcePath;

        if ($this->query !== []) {
            $uri .= '?'.http_build_query($this->query);
        }

        $queryTime = gmdate("Y-m-d\TH:i:s");
        $headers = $headers
            ->withCustomHeader('Content-Type', 'application/json')
            ->withCustomHeader('X-AUTH-QUERYTIME', $queryTime)
            ->withCustomHeader('X-AUTH-KEY', $credentials->authKey($signedPath, $queryTime));

        $request = $psr17Factory->createRequest($this->method->value, $uri);

        foreach ($headers->toArray() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($this->body !== []) {
            $stream = $psr17Factory->createStream(
                json_encode($this->body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
            $request = $request->withBody($stream);
        }

        return $request;
    }
}
