<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Templates;

final class TemplateResponseFixture
{
    /**
     * @var array{id: int, name: string, is_default: bool, cl_languages_id: string}
     */
    public const ATTRIBUTES = [
        'id' => 1,
        'name' => 'Vaikimisi',
        'is_default' => true,
        'cl_languages_id' => 'ET',
    ];
}
