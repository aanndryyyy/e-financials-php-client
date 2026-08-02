<?php

declare(strict_types=1);

use EFinancialsClient\Client;
use EFinancialsClient\Factory;

final class EFinancials
{
    /**
     * Creates a new e-Financials Client with the given API credentials.
     */
    public static function client(
        string $apiKeyId,
        string $apiKeyPublic,
        string $apiKeyPassword,
    ): Client {
        return self::factory()
            ->withApiKeyId($apiKeyId)
            ->withApiKeyPublic($apiKeyPublic)
            ->withApiKeyPassword($apiKeyPassword)
            ->make();
    }

    /**
     * Creates a new factory instance to configure a custom e-Financials Client.
     */
    public static function factory(): Factory
    {
        return new Factory;
    }
}
