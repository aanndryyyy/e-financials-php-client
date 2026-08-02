<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Currencies;

final class CurrencyResponseFixture
{
    /**
     * @var array{id: string, name_est: string, name_eng: string}
     */
    public const ATTRIBUTES = [
        'id' => 'EUR',
        'name_est' => 'Euro',
        'name_eng' => 'Euro',
    ];
}
