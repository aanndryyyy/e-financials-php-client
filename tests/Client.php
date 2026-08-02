<?php

use EFinancialsClient\Client;
use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Resources\Clients;
use EFinancialsClient\Resources\Journals;
use EFinancialsClient\Resources\PurchaseInvoices;
use EFinancialsClient\Resources\SalesInvoices;
use EFinancialsClient\Resources\Templates;
use EFinancialsClient\Resources\Transactions;
use EFinancialsClient\Responses\Clients\ClientResponse;
use EFinancialsClient\Responses\Clients\ListResponse as ClientsListResponse;
use EFinancialsClient\Responses\Currencies\ListResponse as CurrenciesListResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\Testing\Responses\Fixtures\Clients\ClientResponseFixture;
use EFinancialsClient\Transporters\HttpTransporter;
use EFinancialsClient\ValueObjects\ApiCredentials;
use EFinancialsClient\ValueObjects\Transporter\BaseUri;
use EFinancialsClient\ValueObjects\Transporter\Headers;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('creates an auth key for a path', function () {
    $credentials = ApiCredentials::from('key-id', 'public-key', 'secret');
    $queryTime = '2024-01-01T00:00:00';
    $path = '/v1/clients';
    $expectedSignature = base64_encode(hash_hmac(
        'sha384',
        'key-id:2024-01-01T00:00:00:/v1/clients',
        'secret',
        true,
    ));

    expect($credentials->authKey($path, $queryTime))->toBe('public-key:'.$expectedSignature);
});

it('returns decoded json from a successful request', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['ok' => true], JSON_THROW_ON_ERROR)),
    ]);

    $transporter = new HttpTransporter(
        new GuzzleClient(['handler' => HandlerStack::create($mock)]),
        BaseUri::from('https://demo-rmp-api.rik.ee'),
        Headers::create(),
        ApiCredentials::from('key-id', 'public-key', 'secret'),
    );

    $client = new Client($transporter);

    expect($client->accounts()->all())->toBe(['ok' => true]);
});

it('throws a typed exception for http errors', function () {
    $mock = new MockHandler([
        new Response(401, [], 'Unauthorized'),
    ]);

    $transporter = new HttpTransporter(
        new GuzzleClient(['handler' => HandlerStack::create($mock)]),
        BaseUri::from('https://demo-rmp-api.rik.ee'),
        Headers::create(),
        ApiCredentials::from('key-id', 'public-key', 'secret'),
    );

    $client = new Client($transporter);
    $client->accounts()->all();
})->throws(ErrorException::class, 'Unauthorized');

it('exposes resource accessors', function () {
    $client = EFinancials::factory()
        ->withApiKeyId('key-id')
        ->withApiKeyPublic('public-key')
        ->withApiKeyPassword('secret')
        ->withHttpClient(new GuzzleClient(['handler' => HandlerStack::create(new MockHandler)]))
        ->make();

    expect($client->clients())->toBeInstanceOf(Clients::class)
        ->and($client->journals())->toBeInstanceOf(Journals::class)
        ->and($client->salesInvoices())->toBeInstanceOf(SalesInvoices::class)
        ->and($client->purchaseInvoices())->toBeInstanceOf(PurchaseInvoices::class)
        ->and($client->transactions())->toBeInstanceOf(Transactions::class)
        ->and($client->templates())->toBeInstanceOf(Templates::class);
});

it('maps currencies to a typed list response', function () {
    $fake = new ClientFake([
        CurrenciesListResponse::fake(),
    ]);

    $response = $fake->currencies()->all();

    expect($response)->toBeInstanceOf(CurrenciesListResponse::class)
        ->and($response->data[0]->id)->toBe('EUR');

    $fake->assertSent('currencies', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('maps clients to a fuller OpenAPI projection', function () {
    $fake = new ClientFake([
        ClientsListResponse::fake(),
        ClientResponse::fake(),
    ]);

    $list = $fake->clients()->all();

    expect($list)->toBeInstanceOf(ClientsListResponse::class)
        ->and($list->items)->toHaveCount(1)
        ->and($list->items[0])->toBeInstanceOf(ClientResponse::class)
        ->and($list->items[0]->id)->toBe(1916)
        ->and($list->items[0]->name)->toBe('A24 Laen OÜ')
        ->and($list->items[0]->code)->toBe('14168677')
        ->and($list->items[0]->email)->toBeNull()
        ->and($list->items[0]->isStaff)->toBeFalse()
        ->and($list->items[0]->isDeleted)->toBeTrue()
        ->and($list->items[0]->isJuridicalEntity)->toBeTrue()
        ->and($list->items[0]->invoiceElectronicOpts)->toBe([])
        ->and($list->items[0]->toArray())->toEqualCanonicalizing(ClientResponseFixture::ATTRIBUTES);

    $client = $fake->clients()->get(1916);

    expect($client)->toBeInstanceOf(ClientResponse::class)
        ->and($client->id)->toBe(1916)
        ->and($client->clInvoiceCountry)->toBe('EST')
        ->and($client->isAssociateCompany)->toBeFalse()
        ->and($client->isRelatedParty)->toBeFalse();

    $fake->assertSent('clients', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('clients/1916', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('builds a client through the factory facade', function () {
    $client = EFinancials::client('id', 'public', 'password');

    expect($client)->toBeInstanceOf(Client::class);
});
