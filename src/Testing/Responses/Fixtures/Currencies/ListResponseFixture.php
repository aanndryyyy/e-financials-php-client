<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Currencies;

final class ListResponseFixture
{
    /**
     * @var array<int, array{id: string, name_est: string, name_eng: string}>
     */
    public const ATTRIBUTES = [
        [
            'id' => 'EUR',
            'name_est' => 'Euro',
            'name_eng' => 'Euro',
        ],
        [
            'id' => 'USD',
            'name_est' => 'USA dollar',
            'name_eng' => 'US Dollar',
        ],
    ];
}
