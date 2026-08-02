<?php

declare(strict_types=1);

namespace EFinancialsClient\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

final class ErrorException extends Exception
{
    private readonly int $statusCode;

    /**
     * @param  array{code?: int|null, messages?: array<int, string>|null, created_object_id?: int|null}|string  $contents
     */
    public function __construct(
        private readonly string|array $contents,
        public readonly ResponseInterface $response,
    ) {
        $this->statusCode = $response->getStatusCode();

        $contents = is_string($contents) ? ['messages' => [$contents]] : $contents;
        $messages = $contents['messages'] ?? [];
        $message = $messages !== [] ? implode(PHP_EOL, $messages) : 'Unknown error';

        if (isset($contents['code'])) {
            $message = '['.$contents['code'].'] '.$message;
        }

        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorCode(): ?int
    {
        if (is_string($this->contents)) {
            return null;
        }

        return $this->contents['code'] ?? null;
    }

    /**
     * @return array<int, string>
     */
    public function getErrorMessages(): array
    {
        if (is_string($this->contents)) {
            return [$this->contents];
        }

        return $this->contents['messages'] ?? [];
    }

    public function getCreatedObjectId(): ?int
    {
        if (is_string($this->contents)) {
            return null;
        }

        return $this->contents['created_object_id'] ?? null;
    }
}
