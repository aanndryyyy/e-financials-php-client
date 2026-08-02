<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures;

final class ApiResponseFixture
{
    /**
     * @var array{code: int, messages: array<int, string>, created_object_id: int}
     */
    public const ATTRIBUTES = [
        'code' => 0,
        'messages' => ['OK'],
        'created_object_id' => 12345,
    ];
}
