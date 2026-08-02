<?php

declare(strict_types=1);

namespace EFinancialsClient\ValueObjects\Transporter;

/**
 * Composes e-Financials API resource paths for Payload verbs.
 *
 * Keeps HTTP verbs on Payload; this only builds path strings.
 *
 * @internal
 */
final class ResourcePath
{
    private function __construct()
    {
        // ..
    }

    /**
     * Collection / singleton resource path, e.g. `clients` or `invoice_info`.
     */
    public static function collection(string $resource): string
    {
        return trim($resource, '/');
    }

    /**
     * Single-object path with optional action/file suffixes.
     *
     * Examples:
     * - `clients/1916`
     * - `sale_invoices/1698/document_user`
     * - `journals/739/register`
     */
    public static function one(string $resource, int|string $id, string ...$segments): string
    {
        $parts = [self::collection($resource), (string) $id];

        foreach ($segments as $segment) {
            $normalized = trim($segment, '/');

            if ($normalized === '') {
                continue;
            }

            $parts[] = $normalized;
        }

        return implode('/', $parts);
    }
}
