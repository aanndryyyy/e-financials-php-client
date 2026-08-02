<?php

use EFinancialsClient\API\Clients;
use EFinancialsClient\API\Journals;
use EFinancialsClient\API\PurchaseInvoices;
use EFinancialsClient\API\SalesInvoices;
use EFinancialsClient\API\Templates;
use EFinancialsClient\API\Transactions;
use EFinancialsClient\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

it('creates an auth query time in utc', function () {
    $client = new Client(
        apiKeyId: 'id',
        apiKeyPublic: 'public',
        apiKeyPassword: 'password',
    );

    expect($client->createAuthQuerytime())->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}$/');
});

it('creates an auth key for a path', function () {
    $client = new Client(
        apiKeyId: 'key-id',
        apiKeyPublic: 'public-key',
        apiKeyPassword: 'secret',
    );

    $queryTime = '2024-01-01T00:00:00';
    $path = '/v1/clients';
    $expectedSignature = base64_encode(hash_hmac(
        'sha384',
        'key-id:2024-01-01T00:00:00:/v1/clients',
        'secret',
        true,
    ));

    expect($client->createAuthKey($path, $queryTime))->toBe('public-key:'.$expectedSignature);
});

it('returns decoded json from a successful request', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['ok' => true], JSON_THROW_ON_ERROR)),
    ]);

    $client = new Client(
        httpClient: new GuzzleClient(['handler' => HandlerStack::create($mock)]),
        apiKeyId: 'key-id',
        apiKeyPublic: 'public-key',
        apiKeyPassword: 'secret',
    );

    expect($client->request('GET', 'clients'))->toBe(['ok' => true]);
});

it('exposes resource accessors', function () {
    $client = new Client(
        apiKeyId: 'key-id',
        apiKeyPublic: 'public-key',
        apiKeyPassword: 'secret',
    );

    expect($client->clients())->toBeInstanceOf(Clients::class)
        ->and($client->journals())->toBeInstanceOf(Journals::class)
        ->and($client->salesInvoices())->toBeInstanceOf(SalesInvoices::class)
        ->and($client->purchaseInvoices())->toBeInstanceOf(PurchaseInvoices::class)
        ->and($client->transactions())->toBeInstanceOf(Transactions::class)
        ->and($client->templates())->toBeInstanceOf(Templates::class);
});
