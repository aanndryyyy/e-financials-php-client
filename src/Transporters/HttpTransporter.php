<?php

declare(strict_types=1);

namespace EFinancialsClient\Transporters;

use Closure;
use EFinancialsClient\Contracts\TransporterContract;
use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Exceptions\TransporterException;
use EFinancialsClient\Exceptions\UnserializableResponse;
use EFinancialsClient\ValueObjects\ApiCredentials;
use EFinancialsClient\ValueObjects\Transporter\BaseUri;
use EFinancialsClient\ValueObjects\Transporter\Headers;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
final class HttpTransporter implements TransporterContract
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly BaseUri $baseUri,
        private readonly Headers $headers,
        private readonly ApiCredentials $credentials,
    ) {
        // ..
    }

    /**
     * {@inheritDoc}
     */
    public function request(Payload $payload): Response
    {
        $request = $payload->toRequest($this->baseUri, $this->headers, $this->credentials);

        $response = $this->sendRequest(fn (): ResponseInterface => $this->client->sendRequest($request));
        $contents = (string) $response->getBody();

        $this->throwIfError($response, $contents);

        if ($contents === '') {
            return Response::from([]);
        }

        try {
            /** @var array<array-key, mixed>|null $data */
            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException, $response);
        }

        if (! is_array($data)) {
            throw new UnserializableResponse(
                new JsonException('Response JSON must decode to an array.'),
                $response,
            );
        }

        return Response::from($data);
    }

    /**
     * @param  Closure(): ResponseInterface  $callable
     */
    private function sendRequest(Closure $callable): ResponseInterface
    {
        try {
            return $callable();
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }
    }

    private function throwIfError(ResponseInterface $response, string $contents): void
    {
        if ($response->getStatusCode() < 400) {
            return;
        }

        try {
            /** @var array{code?: int|null, messages?: array<int, string>|null, created_object_id?: int|null}|null $data */
            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);

            if (is_array($data) && (isset($data['code']) || isset($data['messages']))) {
                throw new ErrorException($data, $response);
            }
        } catch (JsonException) {
            // Fall through to plain-text / status-based error.
        }

        $message = trim($contents) !== '' ? trim($contents) : 'HTTP '.$response->getStatusCode();

        throw new ErrorException($message, $response);
    }
}
