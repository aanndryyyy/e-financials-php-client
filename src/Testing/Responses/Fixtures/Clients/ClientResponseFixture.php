<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Clients;

final class ClientResponseFixture
{
    /**
     * @var array{id: int, is_client: bool, is_supplier: bool, name: string, code: string, cl_code_country: string, is_member: bool, send_invoice_to_email: bool, send_invoice_to_accounting_email: bool, is_deleted: bool}
     */
    public const ATTRIBUTES = [
        'id' => 6064,
        'is_client' => true,
        'is_supplier' => true,
        'name' => 'Maksu- ja Tolliamet',
        'code' => '70000349',
        'cl_code_country' => 'EST',
        'is_member' => false,
        'send_invoice_to_email' => true,
        'send_invoice_to_accounting_email' => true,
        'is_deleted' => false,
    ];
}
