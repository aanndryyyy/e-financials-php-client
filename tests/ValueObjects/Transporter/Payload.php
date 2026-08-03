<?php

declare(strict_types=1);

use EFinancialsClient\Enums\SaleInvoiceType;
use EFinancialsClient\ValueObjects\ApiCredentials;
use EFinancialsClient\ValueObjects\Transporter\BaseUri;
use EFinancialsClient\ValueObjects\Transporter\Headers;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use Psr\Http\Message\RequestInterface;

function payloadRequest(Payload $payload): RequestInterface
{
    return $payload->toRequest(
        BaseUri::from('https://demo-rmp-api.rik.ee', 'v1'),
        Headers::create(),
        ApiCredentials::from('id', 'public', 'password'),
    );
}

it('unwraps backed enums in the body, at any depth', function () {
    $payload = Payload::post('sale_invoices', [
        'sale_invoice_type' => SaleInvoiceType::CREDIT_INVOICE,
        'nested' => ['type' => SaleInvoiceType::QUOTATION],
        'items' => [
            ['type' => SaleInvoiceType::PREPAYMENT_INVOICE, 'amount' => -1],
        ],
    ]);

    expect($payload->body())->toBe([
        'sale_invoice_type' => 'CREDIT-INVOICE',
        'nested' => ['type' => 'QUOTATION'],
        'items' => [
            ['type' => 'PREPAYMENT-INVOICE', 'amount' => -1],
        ],
    ]);

    $sent = json_decode((string) payloadRequest($payload)->getBody(), true, 512, JSON_THROW_ON_ERROR);

    expect($sent['sale_invoice_type'])->toBe('CREDIT-INVOICE')
        ->and($sent['items'][0]['type'])->toBe('PREPAYMENT-INVOICE');
});

it('unwraps backed enums on patch and put bodies too', function () {
    $body = ['sale_invoice_type' => SaleInvoiceType::INVOICE];

    expect(Payload::patch('sale_invoices/1', $body)->body())->toBe(['sale_invoice_type' => 'INVOICE'])
        ->and(Payload::put('sale_invoices/1/document_user', $body)->body())->toBe(['sale_invoice_type' => 'INVOICE']);
});

it('unwraps backed enums in the query string', function () {
    $payload = Payload::get('sale_invoices', ['type' => SaleInvoiceType::INVOICE, 'page' => 2]);

    expect($payload->query())->toBe(['type' => 'INVOICE', 'page' => 2])
        ->and((string) payloadRequest($payload)->getUri())->toContain('type=INVOICE&page=2');
});

it('leaves scalars, nulls and falsy values untouched', function () {
    $body = [
        'term_days' => 0,
        'show_client_balance' => false,
        'amount' => -1.5,
        'note' => null,
        'title' => 'Krediidi test',
    ];

    expect(Payload::post('sale_invoices', $body)->body())->toBe($body);
});

it('maps every documented sale invoice type', function () {
    expect(array_map(
        fn (SaleInvoiceType $type): string => $type->value,
        SaleInvoiceType::cases(),
    ))->toBe(['INVOICE', 'CREDIT-INVOICE', 'PREPAYMENT-INVOICE', 'QUOTATION']);
});
