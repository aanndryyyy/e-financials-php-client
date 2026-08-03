<?php

declare(strict_types=1);

use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\ValueObjects\Transporter\Payload;

it('rejects a distribution row missing required parameters', function () {
    $fake = new ClientFake([ApiResponse::fake()]);

    expect(fn () => $fake->transactions()->register(2672, [
        ['related_table' => 'accounts', 'amount' => 10.0],
        ['related_table' => 'accounts'],
    ]))->toThrow(
        InvalidArgumentException::class,
        'Distribution row 1 is missing required parameter(s): amount'
    );
});

it('names every missing key in the offending row', function () {
    $fake = new ClientFake([ApiResponse::fake()]);

    expect(fn () => $fake->transactions()->register(2672, [
        ['related_id' => 1010],
    ]))->toThrow(
        InvalidArgumentException::class,
        'Distribution row 0 is missing required parameter(s): related_table, amount'
    );
});

it('sends valid distribution rows as the request body', function () {
    $fake = new ClientFake([ApiResponse::fake()]);

    $fake->transactions()->register(2672, [
        ['related_table' => 'accounts', 'related_id' => 1010, 'amount' => 2348.32],
    ]);

    $fake->assertSent(
        'transactions/2672/register',
        fn (Payload $payload): bool => $payload->method()->value === 'PATCH'
            && $payload->body() === [
                ['related_table' => 'accounts', 'related_id' => 1010, 'amount' => 2348.32],
            ]
    );
});

it('sends no body when no distributions are supplied', function () {
    $fake = new ClientFake([ApiResponse::fake()]);

    $fake->transactions()->register(2672);

    // The spec does not mark the register requestBody as required, so an
    // empty distribution list must send no body at all.
    $fake->assertSent(
        'transactions/2672/register',
        fn (Payload $payload): bool => $payload->body() === []
    );
});
