<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects;

/**
 * @internal
 */
final readonly class ApiCredentials
{
    private function __construct(
        private string $apiKeyId,
        private string $apiKeyPublic,
        private string $apiKeyPassword,
    ) {
        // ..
    }

    public static function from(string $apiKeyId, string $apiKeyPublic, string $apiKeyPassword): self
    {
        return new self($apiKeyId, $apiKeyPublic, $apiKeyPassword);
    }

    public function id(): string
    {
        return $this->apiKeyId;
    }

    public function publicKey(): string
    {
        return $this->apiKeyPublic;
    }

    public function password(): string
    {
        return $this->apiKeyPassword;
    }

    /**
     * Creates the X-AUTH-KEY value for the given path and query time.
     *
     * Signature: BASE64(HMAC-SHA-384("{apiKeyId}:{queryTime}:{path}", apiKeyPassword))
     */
    public function authKey(string $path, string $queryTime): string
    {
        $data = $this->apiKeyId.':'.$queryTime.':'.$path;
        $signature = base64_encode(hash_hmac('sha384', $data, $this->apiKeyPassword, true));

        return $this->apiKeyPublic.':'.$signature;
    }
}
