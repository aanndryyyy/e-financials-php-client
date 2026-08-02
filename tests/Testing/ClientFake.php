<?php

use EFinancialsClient\Enums\Transporter\Method;
use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Currencies\ListResponse as CurrenciesListResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\Testing\Exceptions\NoFakeResponsesException;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Tests\Fixtures\Responses\MissingFixtureResponse;

covers(ClientFake::class);

it('delegates resource accessors through the real client', function () {
    $fake = new ClientFake([
        CurrenciesListResponse::fake(),
    ]);

    $response = $fake->currencies()->all();

    expect($response)->toBeInstanceOf(CurrenciesListResponse::class)
        ->and($response->data[0]->id)->toBe('EUR')
        ->and($fake->recorded())->toHaveCount(1);
});

it('matches assertSent against the exact resource path', function () {
    $fake = new ClientFake([
        ['ok' => true],
        ['ok' => true],
    ]);

    $fake->journals()->get(1);
    $fake->journals()->getFile(1);

    $fake->assertSent('journals/1');
    $fake->assertNotSent('journals');
    $fake->assertSentTimes('journals/1', 1);
    $fake->assertSent('journals/1/document_user');
});

it('counts exact resource sends with assertSent times', function () {
    $fake = new ClientFake([
        ApiResponse::fake(),
        ApiResponse::fake(),
        ApiResponse::fake(),
    ]);

    $fake->products()->deactivate(1);
    $fake->products()->deactivate(1);
    $fake->products()->reactivate(1);

    $fake->assertSent('products/1/deactivate', 2);
    $fake->assertSentTimes('products/1/reactivate', 1);
    $fake->assertSent(
        'products/1/deactivate',
        fn (Payload $payload): bool => $payload->method() === Method::PATCH,
    );
});

it('asserts when nothing was sent', function () {
    $fake = new ClientFake;

    $fake->assertNothingSent();
    $fake->assertNotSent('currencies');
});

it('appends responses with addResponses', function () {
    $fake = new ClientFake([
        CurrenciesListResponse::fake(),
    ]);

    $fake->addResponses([
        CurrenciesListResponse::from([
            ['id' => 'USD', 'name_est' => 'USA dollar', 'name_eng' => 'US Dollar'],
        ]),
    ]);

    expect($fake->currencies()->all()->data[0]->id)->toBe('EUR')
        ->and($fake->currencies()->all()->data[0]->id)->toBe('USD');
});

it('accepts array and json string fake responses', function () {
    $fake = new ClientFake([
        ['current_page' => 1, 'total_pages' => 1, 'items' => []],
        '{"current_page":1,"total_pages":1,"items":[]}',
    ]);

    expect($fake->products()->all()->items)->toBe([])
        ->and($fake->products()->all()->items)->toBe([])
        ->and($fake->recordedPairs())->toHaveCount(2);
});

it('rethrows queued throwables', function () {
    $fake = new ClientFake([
        new ErrorException('nope', new Psr7Response(500)),
    ]);

    $fake->journals()->all();
})->throws(ErrorException::class, 'nope');

it('throws a typed exception when the response queue is empty', function () {
    $fake = new ClientFake;

    $fake->currencies()->all();
})->throws(NoFakeResponsesException::class, 'No fake responses left.');

it('fails clearly when a response fixture class is missing', function () {
    MissingFixtureResponse::fake();
})->throws(RuntimeException::class, 'Missing fixture class');
