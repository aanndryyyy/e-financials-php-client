<?php

use EFinancialsClient\Client;
use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Resources\Clients;
use EFinancialsClient\Resources\Journals;
use EFinancialsClient\Resources\PurchaseInvoices;
use EFinancialsClient\Resources\SalesInvoices;
use EFinancialsClient\Resources\Templates;
use EFinancialsClient\Resources\Transactions;
use EFinancialsClient\Responses\Accounts\AccountResponse;
use EFinancialsClient\Responses\Accounts\ListResponse as AccountsListResponse;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\Bank\BankAccountResponse;
use EFinancialsClient\Responses\Bank\ListResponse as BankAccountsListResponse;
use EFinancialsClient\Responses\Clients\ClientResponse;
use EFinancialsClient\Responses\Clients\ListResponse as ClientsListResponse;
use EFinancialsClient\Responses\CostProfitCentres\ListResponse as CostProfitCentresListResponse;
use EFinancialsClient\Responses\Currencies\ListResponse as CurrenciesListResponse;
use EFinancialsClient\Responses\Products\ListResponse as ProductsListResponse;
use EFinancialsClient\Responses\Products\ProductResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\Testing\Responses\Fixtures\Accounts\AccountResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Bank\BankAccountResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Clients\ClientResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Products\ProductResponseFixture;
use EFinancialsClient\Transporters\HttpTransporter;
use EFinancialsClient\ValueObjects\ApiCredentials;
use EFinancialsClient\ValueObjects\Transporter\BaseUri;
use EFinancialsClient\ValueObjects\Transporter\Headers;
use EFinancialsClient\ValueObjects\Transporter\Payload;
use Tests\Fakes\HttpClientFake;

covers(Client::class, HttpTransporter::class, ApiCredentials::class);

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
    $transporter = new HttpTransporter(
        HttpClientFake::sequence([
            HttpClientFake::response(200, ['ok' => true]),
        ]),
        BaseUri::from('https://demo-rmp-api.rik.ee'),
        Headers::create(),
        ApiCredentials::from('key-id', 'public-key', 'secret'),
    );

    $client = new Client($transporter);

    expect($client->journals()->all())->toBe(['ok' => true]);
});

it('throws a typed exception for http errors', function () {
    $transporter = new HttpTransporter(
        HttpClientFake::sequence([
            HttpClientFake::response(401, 'Unauthorized'),
        ]),
        BaseUri::from('https://demo-rmp-api.rik.ee'),
        Headers::create(),
        ApiCredentials::from('key-id', 'public-key', 'secret'),
    );

    $client = new Client($transporter);
    $client->journals()->all();
})->throws(ErrorException::class, 'Unauthorized');

it('exposes resource accessors', function () {
    $client = EFinancials::factory()
        ->withApiKeyId('key-id')
        ->withApiKeyPublic('public-key')
        ->withApiKeyPassword('secret')
        ->withHttpClient(HttpClientFake::sequence([]))
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
        ->and($list->items[0]->toArray())->toBe(
            ClientResponse::from(ClientResponseFixture::ATTRIBUTES)->toArray()
        );

    $client = $fake->clients()->get(1916);

    expect($client)->toBeInstanceOf(ClientResponse::class)
        ->and($client->id)->toBe(1916)
        ->and($client->clInvoiceCountry)->toBe('EST')
        ->and($client->isAssociateCompany)->toBeFalse()
        ->and($client->isRelatedParty)->toBeFalse();

    $fake->assertSent('clients', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('clients/1916', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('maps accounts and bank accounts to fuller OpenAPI projections', function () {
    $fake = new ClientFake([
        AccountsListResponse::fake(),
        BankAccountsListResponse::fake(),
        BankAccountResponse::fake(),
        CostProfitCentresListResponse::fake(),
        ApiFileResponse::fake(),
    ]);

    $accounts = $fake->accounts()->all();

    expect($accounts)->toBeInstanceOf(AccountsListResponse::class)
        ->and($accounts->data[0])->toBeInstanceOf(AccountResponse::class)
        ->and($accounts->data[0]->id)->toBe(1010)
        ->and($accounts->data[0]->nameEst)->toBe('Sularaha kassas')
        ->and($accounts->data[0]->clAccountGroups)->toBe(['AR', 'MTY', 'SA'])
        ->and($accounts->data[0]->toArray())->toBe(
            AccountResponse::from(AccountResponseFixture::ATTRIBUTES)->toArray()
        );

    $bankAccounts = $fake->bank()->all();

    expect($bankAccounts)->toBeInstanceOf(BankAccountsListResponse::class)
        ->and($bankAccounts->data[0]->accountNo)->toBe('EE123456780012345678');

    $bankAccount = $fake->bank()->get(16);

    expect($bankAccount)->toBeInstanceOf(BankAccountResponse::class)
        ->and($bankAccount->toArray())->toBe(
            BankAccountResponse::from(BankAccountResponseFixture::ATTRIBUTES)->toArray()
        );

    $centres = $fake->costProfitCentres()->all();

    expect($centres)->toBeInstanceOf(CostProfitCentresListResponse::class)
        ->and($centres->items[0]->name)->toBe('Elekter')
        ->and($centres->items[0]->clProjectsType)->toBe('PROJECT');

    $file = ApiFileResponse::fake();

    expect($file)->toBeInstanceOf(ApiFileResponse::class)
        ->and($file->name)->toBe('Arve_NX000001_20220109_TESTCLIENT.pdf')
        ->and($file->contents)->toBe('JVBERi0xLjQK');

    $fake->assertSent('accounts', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('bank_accounts', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('projects', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('maps products to a fuller OpenAPI projection', function () {
    $fake = new ClientFake([
        ProductsListResponse::fake(),
        ProductResponse::fake(),
    ]);

    $list = $fake->products()->all();

    expect($list)->toBeInstanceOf(ProductsListResponse::class)
        ->and($list->items)->toHaveCount(1)
        ->and($list->items[0])->toBeInstanceOf(ProductResponse::class)
        ->and($list->items[0]->id)->toBe(36166)
        ->and($list->items[0]->name)->toBe('printer HP')
        ->and($list->items[0]->code)->toBe('HP')
        ->and($list->items[0]->salesPrice)->toBe(170.0)
        ->and($list->items[0]->translations)->toBe(['products__name__1' => ''])
        ->and($list->items[0]->isDeleted)->toBeFalse()
        ->and($list->items[0]->toArray())->toBe(
            ProductResponse::from(ProductResponseFixture::ATTRIBUTES)->toArray()
        );

    $product = $fake->products()->get(36166);

    expect($product)->toBeInstanceOf(ProductResponse::class)
        ->and($product->priceCurrency)->toBe('EUR')
        ->and($product->unit)->toBe('tk');

    $fake->assertSent('products', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('products/36166', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('builds a client through the factory facade', function () {
    $client = EFinancials::client('id', 'public', 'password');

    expect($client)->toBeInstanceOf(Client::class);
});
