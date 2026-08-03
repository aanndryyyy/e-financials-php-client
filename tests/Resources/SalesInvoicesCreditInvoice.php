<?php

declare(strict_types=1);

use EFinancialsClient\Client;
use EFinancialsClient\Enums\SaleInvoiceType;
use EFinancialsClient\Responses\SalesInvoices\SaleInvoiceResponse;
use Tests\Fakes\HttpClientFake;

/**
 * Credit invoice (kreeditarve) support.
 *
 * The API has no dedicated endpoint: a credit invoice is a POST /v1/sale_invoices
 * with sale_invoice_type = "CREDIT-INVOICE", credit_sale_invoices_id pointing at a
 * CONFIRMED original, negative items[].amount (positive unit_net_price) and the
 * original's number_suffix. Any other sale_invoice_type with
 * credit_sale_invoices_id set makes the server return HTTP 500.
 */
const CREDIT_INVOICE_PAYLOAD = [
    'sale_invoice_type' => 'CREDIT-INVOICE',
    'credit_sale_invoices_id' => 6612,
    'cl_templates_id' => 1,
    'clients_id' => 6097,
    'cl_countries_id' => 'EST',
    'number_prefix' => 'ARB-',
    'number_suffix' => '990030',
    'create_date' => '2026-08-03',
    'journal_date' => '2026-08-03',
    'term_days' => 0,
    'cl_currencies_id' => 'EUR',
    'show_client_balance' => false,
    'receivable_accounts_id' => 1210,
    'items' => [
        [
            'custom_title' => 'Krediidi test',
            'products_id' => 2320,
            'amount' => -1,
            'unit_net_price' => 100,
            'vat_rate' => 0,
            'cl_sale_articles_id' => 35,
            'sale_accounts_id' => 1340,
        ],
    ],
];

function creditInvoiceClient(HttpClientFake $http): Client
{
    return EFinancials::factory()
        ->withApiKeyId('id')
        ->withApiKeyPublic('public')
        ->withApiKeyPassword('password')
        ->withHttpClient($http)
        ->make();
}

it('sends the documented credit invoice payload verbatim', function () {
    $http = HttpClientFake::sequence([
        HttpClientFake::response(200, [
            'code' => 0,
            'created_object_id' => 6613,
            'messages' => ['Invoice saved.'],
        ]),
    ]);

    $response = creditInvoiceClient($http)->salesInvoices()->create(CREDIT_INVOICE_PAYLOAD);

    expect($response->createdObjectId)->toBe(6613);

    $request = $http->requests()[0];

    expect((string) $request->getMethod())->toBe('POST')
        ->and((string) $request->getUri())->toContain('/v1/sale_invoices');

    /** @var array<string, mixed> $sent */
    $sent = json_decode((string) $request->getBody(), true, 512, JSON_THROW_ON_ERROR);

    // Nothing is filtered, coerced or reordered on the way out: the falsy
    // (term_days, show_client_balance, vat_rate) and negative (amount) values
    // that carry the credit semantics must survive intact.
    expect($sent)->toBe(CREDIT_INVOICE_PAYLOAD)
        ->and($sent['sale_invoice_type'])->toBe('CREDIT-INVOICE')
        ->and($sent['credit_sale_invoices_id'])->toBe(6612)
        ->and($sent['items'][0]['amount'])->toBe(-1)
        ->and($sent['items'][0]['unit_net_price'])->toBe(100)
        ->and($sent['term_days'])->toBe(0)
        ->and($sent['show_client_balance'])->toBeFalse();
});

it('accepts the SaleInvoiceType enum for sale_invoice_type', function () {
    $http = HttpClientFake::sequence([
        HttpClientFake::response(200, ['code' => 0, 'created_object_id' => 6613]),
    ]);

    creditInvoiceClient($http)->salesInvoices()->create(
        ['sale_invoice_type' => SaleInvoiceType::CREDIT_INVOICE] + CREDIT_INVOICE_PAYLOAD
    );

    /** @var array<string, mixed> $sent */
    $sent = json_decode((string) $http->requests()[0]->getBody(), true, 512, JSON_THROW_ON_ERROR);

    expect($sent['sale_invoice_type'])->toBe('CREDIT-INVOICE');
});

it('registers, invalidates and deletes a credit invoice', function () {
    $ok = ['code' => 0, 'messages' => ['OK']];

    $http = HttpClientFake::sequence([
        HttpClientFake::response(200, $ok),
        HttpClientFake::response(200, $ok),
        HttpClientFake::response(200, $ok),
    ]);

    $invoices = creditInvoiceClient($http)->salesInvoices();

    $invoices->register(6613);
    $invoices->invalidate(6613);
    $invoices->delete(6613);

    $sent = array_map(
        fn ($request): string => $request->getMethod().' '.$request->getUri()->getPath(),
        $http->requests(),
    );

    // Unwind order for a credited original is strictly child-first:
    // invalidate credit -> delete credit -> invalidate original -> delete original.
    expect($sent)->toBe([
        'PATCH /v1/sale_invoices/6613/register',
        'PATCH /v1/sale_invoices/6613/invalidate',
        'DELETE /v1/sale_invoices/6613',
    ]);
});

it('reads back the server-computed negative totals and credit links', function () {
    $invoice = SaleInvoiceResponse::from([
        'id' => 6613,
        'sale_invoice_type' => 'CREDIT-INVOICE',
        'number' => 'ARB-990030K',
        'credit_sale_invoices_id' => 6612,
        'credit_invoice_payment_type' => null,
        'net_price' => -100.0,
        'gross_price' => -100.0,
        'credit_invoices' => [],
        'items' => [
            [
                'id' => 1,
                'amount' => -1.0,
                'unit_net_price' => 100.0,
                'total_net_price' => -100.0,
            ],
        ],
    ]);

    expect($invoice->saleInvoiceType)->toBe('CREDIT-INVOICE')
        ->and($invoice->creditSaleInvoicesId)->toBe(6612)
        ->and($invoice->creditInvoicePaymentType)->toBeNull()
        ->and($invoice->netPrice)->toBe(-100.0)
        ->and($invoice->grossPrice)->toBe(-100.0)
        ->and($invoice->items[0]->amount)->toBe(-1.0)
        ->and($invoice->items[0]->unitNetPrice)->toBe(100.0)
        ->and($invoice->items[0]->totalNetPrice)->toBe(-100.0);
});

it('exposes credit_invoices on the original so callers can tell it was credited', function () {
    $original = SaleInvoiceResponse::from([
        'id' => 6612,
        'sale_invoice_type' => 'INVOICE',
        'credit_invoices' => [6613],
    ]);

    expect($original->creditInvoices)->toBe([6613]);
});
