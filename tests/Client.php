<?php

use EFinancialsClient\Client;
use EFinancialsClient\Contracts\Resources\ClientsContract;
use EFinancialsClient\Contracts\Resources\JournalsContract;
use EFinancialsClient\Contracts\Resources\PurchaseInvoicesContract;
use EFinancialsClient\Contracts\Resources\SalesInvoicesContract;
use EFinancialsClient\Contracts\Resources\TemplatesContract;
use EFinancialsClient\Contracts\Resources\TransactionsContract;
use EFinancialsClient\Exceptions\ErrorException;
use EFinancialsClient\Responses\Accounts\AccountResponse;
use EFinancialsClient\Responses\Accounts\ListResponse as AccountsListResponse;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\Bank\BankAccountResponse;
use EFinancialsClient\Responses\Bank\ListResponse as BankAccountsListResponse;
use EFinancialsClient\Responses\Clients\ClientResponse;
use EFinancialsClient\Responses\Clients\ListResponse as ClientsListResponse;
use EFinancialsClient\Responses\CostProfitCentres\ListResponse as CostProfitCentresListResponse;
use EFinancialsClient\Responses\Currencies\ListResponse as CurrenciesListResponse;
use EFinancialsClient\Responses\Invoices\InvoiceInfoResponse;
use EFinancialsClient\Responses\Invoices\InvoiceSeriesResponse;
use EFinancialsClient\Responses\Invoices\ListResponse as InvoicesListResponse;
use EFinancialsClient\Responses\Journals\JournalResponse;
use EFinancialsClient\Responses\Journals\ListResponse as JournalsListResponse;
use EFinancialsClient\Responses\Journals\PostingResponse;
use EFinancialsClient\Responses\Products\ListResponse as ProductsListResponse;
use EFinancialsClient\Responses\Products\ProductResponse;
use EFinancialsClient\Responses\Transactions\ListResponse as TransactionsListResponse;
use EFinancialsClient\Responses\Transactions\TransactionResponse;
use EFinancialsClient\Testing\ClientFake;
use EFinancialsClient\Testing\Responses\Fixtures\Accounts\AccountResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Bank\BankAccountResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Clients\ClientResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Invoices\InvoiceInfoResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Invoices\InvoiceSeriesResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Journals\JournalResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Products\ProductResponseFixture;
use EFinancialsClient\Testing\Responses\Fixtures\Transactions\TransactionResponseFixture;
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

    expect($client->salesInvoices()->all())->toBe(['ok' => true]);
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
    $client->salesInvoices()->all();
})->throws(ErrorException::class, 'Unauthorized');

it('exposes resource accessors', function () {
    $client = EFinancials::factory()
        ->withApiKeyId('key-id')
        ->withApiKeyPublic('public-key')
        ->withApiKeyPassword('secret')
        ->withHttpClient(HttpClientFake::sequence([]))
        ->make();

    expect($client->clients())->toBeInstanceOf(ClientsContract::class)
        ->and($client->journals())->toBeInstanceOf(JournalsContract::class)
        ->and($client->salesInvoices())->toBeInstanceOf(SalesInvoicesContract::class)
        ->and($client->purchaseInvoices())->toBeInstanceOf(PurchaseInvoicesContract::class)
        ->and($client->transactions())->toBeInstanceOf(TransactionsContract::class)
        ->and($client->templates())->toBeInstanceOf(TemplatesContract::class);
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

it('maps invoice series and invoice info to fuller OpenAPI projections', function () {
    $fake = new ClientFake([
        InvoicesListResponse::fake(),
        InvoiceSeriesResponse::fake(),
        InvoiceInfoResponse::fake(),
    ]);

    $list = $fake->invoices()->all();

    expect($list)->toBeInstanceOf(InvoicesListResponse::class)
        ->and($list->data)->toHaveCount(1)
        ->and($list->data[0])->toBeInstanceOf(InvoiceSeriesResponse::class)
        ->and($list->data[0]->id)->toBe(3)
        ->and($list->data[0]->numberPrefix)->toBe('NX')
        ->and($list->data[0]->overdueCharge)->toBe(0.15)
        ->and($list->data[0]->toArray())->toBe(
            InvoiceSeriesResponse::from(InvoiceSeriesResponseFixture::ATTRIBUTES)->toArray()
        );

    $series = $fake->invoices()->get(3);

    expect($series)->toBeInstanceOf(InvoiceSeriesResponse::class)
        ->and($series->termDays)->toBe(28)
        ->and($series->isDefault)->toBeFalse();

    $info = $fake->invoices()->allSettings();

    expect($info)->toBeInstanceOf(InvoiceInfoResponse::class)
        ->and($info->email)->toBe('test@mail.ee')
        ->and($info->clTemplatesId)->toBe(1)
        ->and($info->invoiceCompanyName)->toBeNull()
        ->and($info->toArray())->toBe(
            InvoiceInfoResponse::from(InvoiceInfoResponseFixture::ATTRIBUTES)->toArray()
        );

    $fake->assertSent('invoice_series');
    $fake->assertSent('invoice_series/3');
    $fake->assertSent('invoice_info');
});

it('maps journals to a fuller OpenAPI projection', function () {
    $fake = new ClientFake([
        JournalsListResponse::fake(),
        JournalResponse::fake(),
    ]);

    $list = $fake->journals()->all();

    expect($list)->toBeInstanceOf(JournalsListResponse::class)
        ->and($list->items)->toHaveCount(1)
        ->and($list->items[0])->toBeInstanceOf(JournalResponse::class)
        ->and($list->items[0]->id)->toBe(739)
        ->and($list->items[0]->number)->toBe(10008)
        ->and($list->items[0]->operationType)->toBe('EMTA_VAT_DECLARATION')
        ->and($list->items[0]->registered)->toBeTrue()
        ->and($list->items[0]->postings)->toHaveCount(2)
        ->and($list->items[0]->postings[0])->toBeInstanceOf(PostingResponse::class)
        ->and($list->items[0]->postings[0]->accountsId)->toBe(2511)
        ->and($list->items[0]->postings[0]->type)->toBe('D')
        ->and($list->items[0]->isDeleted)->toBeFalse()
        ->and($list->items[0]->toArray())->toBe(
            JournalResponse::from(JournalResponseFixture::ATTRIBUTES)->toArray()
        );

    $journal = $fake->journals()->get(739);

    expect($journal)->toBeInstanceOf(JournalResponse::class)
        ->and($journal->documentNumber)->toBe('EMTA KMD 31.05.2014')
        ->and($journal->insertDate)->toBe('2014-06-20')
        ->and($journal->registerDate)->toBe('2014-10-29');

    $fake->assertSent('journals', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('journals/739', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('maps transactions to a fuller OpenAPI projection', function () {
    $fake = new ClientFake([
        TransactionsListResponse::fake(),
        TransactionResponse::fake(),
    ]);

    $list = $fake->transactions()->all();

    expect($list)->toBeInstanceOf(TransactionsListResponse::class)
        ->and($list->items)->toHaveCount(1)
        ->and($list->items[0])->toBeInstanceOf(TransactionResponse::class)
        ->and($list->items[0]->id)->toBe(2672)
        ->and($list->items[0]->accountsId)->toBe(1010)
        ->and($list->items[0]->amount)->toBe(2348.32)
        ->and($list->items[0]->status)->toBe('CONFIRMED')
        ->and($list->items[0]->type)->toBe('D')
        ->and($list->items[0]->isDeleted)->toBeFalse()
        ->and($list->items[0]->items)->toBe([])
        ->and($list->items[0]->toArray())->toBe(
            TransactionResponse::from(TransactionResponseFixture::ATTRIBUTES)->toArray()
        );

    $transaction = $fake->transactions()->get(2672);

    expect($transaction)->toBeInstanceOf(TransactionResponse::class)
        ->and($transaction->clCurrenciesId)->toBe('EUR')
        ->and($transaction->date)->toBe('2015-01-31')
        ->and($transaction->operationType)->toBeNull();

    $fake->assertSent('transactions', fn (Payload $payload): bool => $payload->method()->value === 'GET');
    $fake->assertSent('transactions/2672', fn (Payload $payload): bool => $payload->method()->value === 'GET');
});

it('builds a client through the factory facade', function () {
    $client = EFinancials::client('id', 'public', 'password');

    expect($client)->toBeInstanceOf(Client::class);
});
