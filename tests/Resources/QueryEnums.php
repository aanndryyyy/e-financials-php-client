<?php

declare(strict_types=1);

use EFinancialsClient\Enums\InvoiceStatus;
use EFinancialsClient\Enums\PaymentStatus;
use EFinancialsClient\Enums\TransactionStatus;
use EFinancialsClient\Enums\TransactionType;
use EFinancialsClient\Responses\PurchaseInvoices\ListResponse as PurchaseInvoicesListResponse;
use EFinancialsClient\Responses\SalesInvoices\ListResponse as SalesInvoicesListResponse;
use EFinancialsClient\Responses\Transactions\ListResponse as TransactionsListResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\ValueObjects\Transporter\Payload;

it('matches the enum cases declared in the OpenAPI spec', function () {
    expect(array_column(TransactionStatus::cases(), 'value'))->toBe(['PROJECT', 'CONFIRMED', 'VOID'])
        ->and(array_column(TransactionType::cases(), 'value'))->toBe(['C', 'D'])
        // The invoice status enum deliberately has no VOID case; the spec lists
        // only PROJECT and CONFIRMED for sale/purchase invoices.
        ->and(array_column(InvoiceStatus::cases(), 'value'))->toBe(['PROJECT', 'CONFIRMED'])
        ->and(array_column(PaymentStatus::cases(), 'value'))->toBe(['PAID', 'PARTIALLY_PAID', 'NOT_PAID']);
});

it('unwraps transaction enums into the query string', function () {
    $fake = new ClientFake([TransactionsListResponse::fake()]);

    $fake->transactions()->all(
        status: TransactionStatus::CONFIRMED,
        type: TransactionType::DEBIT,
    );

    $fake->assertSent('transactions', fn (Payload $payload): bool => $payload->query() === [
        'status' => 'CONFIRMED',
        'type' => 'D',
    ]);
});

it('unwraps sale invoice enums into the query string', function () {
    $fake = new ClientFake([SalesInvoicesListResponse::fake()]);

    $fake->salesInvoices()->all(
        status: InvoiceStatus::PROJECT,
        paymentStatus: PaymentStatus::NOT_PAID,
    );

    $fake->assertSent('sale_invoices', fn (Payload $payload): bool => $payload->query() === [
        'status' => 'PROJECT',
        'payment_status' => 'NOT_PAID',
    ]);
});

it('unwraps purchase invoice enums into the query string', function () {
    $fake = new ClientFake([PurchaseInvoicesListResponse::fake()]);

    $fake->purchaseInvoices()->all(
        status: InvoiceStatus::CONFIRMED,
        paymentStatus: PaymentStatus::PARTIALLY_PAID,
    );

    $fake->assertSent('purchase_invoices', fn (Payload $payload): bool => $payload->query() === [
        'status' => 'CONFIRMED',
        'payment_status' => 'PARTIALLY_PAID',
    ]);
});

it('still accepts raw strings for the same parameters', function () {
    $fake = new ClientFake([TransactionsListResponse::fake()]);

    $fake->transactions()->all(status: 'CONFIRMED', type: 'D');

    $fake->assertSent('transactions', fn (Payload $payload): bool => $payload->query() === [
        'status' => 'CONFIRMED',
        'type' => 'D',
    ]);
});

it('omits the enum parameters entirely when they are not supplied', function () {
    $fake = new ClientFake([TransactionsListResponse::fake()]);

    $fake->transactions()->all();

    $fake->assertSent('transactions', fn (Payload $payload): bool => $payload->query() === []);
});
