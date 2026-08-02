<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Clients;

final class ClientResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 6064,
        'is_client' => true,
        'is_supplier' => true,
        'is_staff' => false,
        'name' => 'Maksu- ja Tolliamet',
        'code' => '70000349',
        'cl_code_country' => 'EST',
        'is_member' => false,
        'send_invoice_to_email' => true,
        'send_invoice_to_accounting_email' => true,
        'is_deleted' => false,
        'email' => 'emta@emta.ee',
    ];
}
