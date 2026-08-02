<?php

declare(strict_types=1);

namespace EFinancialsClient;

use EFinancialsClient\Transporters\HttpTransporter;
use EFinancialsClient\ValueObjects\ApiCredentials;
use EFinancialsClient\ValueObjects\Transporter\BaseUri;
use EFinancialsClient\ValueObjects\Transporter\Headers;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;

final class Factory
{
    private ?string $apiKeyId = null;

    private ?string $apiKeyPublic = null;

    private ?string $apiKeyPassword = null;

    private ?ClientInterface $httpClient = null;

    private ?string $baseUri = null;

    private string $apiVersion = 'v1';

    /**
     * @var array<string, string>
     */
    private array $headers = [];

    /**
     * Sets the API key ID used when signing requests.
     */
    public function withApiKeyId(string $apiKeyId): self
    {
        $this->apiKeyId = trim($apiKeyId);

        return $this;
    }

    /**
     * Sets the public API key value sent in X-AUTH-KEY.
     */
    public function withApiKeyPublic(string $apiKeyPublic): self
    {
        $this->apiKeyPublic = trim($apiKeyPublic);

        return $this;
    }

    /**
     * Sets the API key password used for HMAC signatures.
     */
    public function withApiKeyPassword(string $apiKeyPassword): self
    {
        $this->apiKeyPassword = $apiKeyPassword;

        return $this;
    }

    /**
     * Sets the HTTP client for the requests.
     * If no client is provided the factory will try to find one using PSR-18 HTTP Client Discovery.
     */
    public function withHttpClient(ClientInterface $client): self
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Sets the base URI for the requests.
     * Defaults to the e-Arveldaja demo API.
     */
    public function withBaseUri(string $baseUri): self
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Sets the API version path segment (default: v1).
     */
    public function withApiVersion(string $apiVersion): self
    {
        $this->apiVersion = trim($apiVersion, '/');

        return $this;
    }

    /**
     * Adds a custom HTTP header to the requests.
     */
    public function withHttpHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Creates a new e-Financials Client.
     */
    public function make(): Client
    {
        $credentials = ApiCredentials::from(
            $this->apiKeyId ?? '',
            $this->apiKeyPublic ?? '',
            $this->apiKeyPassword ?? '',
        );

        $headers = Headers::create();
        foreach ($this->headers as $name => $value) {
            $headers = $headers->withCustomHeader($name, $value);
        }

        $baseUri = BaseUri::from(
            ($this->baseUri !== null && $this->baseUri !== '') ? $this->baseUri : 'https://demo-rmp-api.rik.ee',
            $this->apiVersion,
        );

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new HttpTransporter($client, $baseUri, $headers, $credentials);

        return new Client($transporter);
    }
}
