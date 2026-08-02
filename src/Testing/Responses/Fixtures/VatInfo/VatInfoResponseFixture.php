<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\VatInfo;

final class VatInfoResponseFixture
{
    /**
     * @var array{vat_number: string, tax_refnumber: string}
     */
    public const ATTRIBUTES = [
        'vat_number' => 'EE100523377',
        'tax_refnumber' => '14332434',
    ];
}
