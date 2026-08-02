<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects\Transporter;

use EFinancialsClient\Contracts\StringableContract;

/**
 * @internal
 */
final class BaseUri implements StringableContract
{
    private function __construct(
        private readonly string $baseUri,
        private readonly string $apiVersion,
    ) {
        // ..
    }

    public static function from(string $baseUri, string $apiVersion = 'v1'): self
    {
        return new self($baseUri, trim($apiVersion, '/'));
    }

    /**
     * Returns the absolute base URI including the API version segment.
     */
    public function toString(): string
    {
        $baseUri = $this->baseUri;

        foreach (['http://', 'https://'] as $protocol) {
            if (str_starts_with($baseUri, $protocol)) {
                return rtrim($baseUri, '/').'/'.$this->apiVersion.'/';
            }
        }

        return 'https://'.rtrim($baseUri, '/').'/'.$this->apiVersion.'/';
    }

    /**
     * Returns the path used for request signing (version + resource path).
     */
    public function signedPath(string $resourcePath): string
    {
        return '/'.$this->apiVersion.'/'.ltrim($resourcePath, '/');
    }
}
