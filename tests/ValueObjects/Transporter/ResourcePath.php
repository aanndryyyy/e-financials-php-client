<?php

use EFinancialsClient\ValueObjects\Transporter\ResourcePath;

it('builds collection paths', function () {
    expect(ResourcePath::collection('clients'))->toBe('clients')
        ->and(ResourcePath::collection('/invoice_info/'))->toBe('invoice_info');
});

it('builds single-object paths with optional suffixes', function () {
    expect(ResourcePath::one('clients', 1916))->toBe('clients/1916')
        ->and(ResourcePath::one('sale_invoices', 1698, 'document_user'))->toBe('sale_invoices/1698/document_user')
        ->and(ResourcePath::one('journals', 739, 'register'))->toBe('journals/739/register')
        ->and(ResourcePath::one('sale_invoices', '1698', '/pdf_system/'))->toBe('sale_invoices/1698/pdf_system');
});
