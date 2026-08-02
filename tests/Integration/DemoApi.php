<?php

use EFinancialsClient\Responses\AccountDimensions\ListResponse as AccountDimensionsListResponse;
use EFinancialsClient\Responses\Accounts\ListResponse as AccountsListResponse;
use EFinancialsClient\Responses\Bank\ListResponse as BankAccountsListResponse;
use EFinancialsClient\Responses\Clients\ListResponse as ClientsListResponse;
use EFinancialsClient\Responses\CostProfitCentres\ListResponse as CostProfitCentresListResponse;
use EFinancialsClient\Responses\Currencies\ListResponse as CurrenciesListResponse;
use EFinancialsClient\Responses\Products\ListResponse as ProductsListResponse;
use EFinancialsClient\Responses\PurchaseArticles\ListResponse as PurchaseArticlesListResponse;
use EFinancialsClient\Responses\SalesArticles\ListResponse as SalesArticlesListResponse;
use EFinancialsClient\Responses\Templates\ListResponse as TemplatesListResponse;
use EFinancialsClient\Responses\VatInfo\VatInfoResponse;

$hasCredentials = is_string(getenv('E_FINANCIALS_API_KEY_ID') ?: null)
    && getenv('E_FINANCIALS_API_KEY_ID') !== ''
    && is_string(getenv('E_FINANCIALS_API_KEY_PUBLIC') ?: null)
    && getenv('E_FINANCIALS_API_KEY_PUBLIC') !== ''
    && is_string(getenv('E_FINANCIALS_API_KEY_PASSWORD') ?: null)
    && getenv('E_FINANCIALS_API_KEY_PASSWORD') !== '';

it('validates demo api response shapes', function () {
    $client = EFinancials::factory()
        ->withApiKeyId((string) getenv('E_FINANCIALS_API_KEY_ID'))
        ->withApiKeyPublic((string) getenv('E_FINANCIALS_API_KEY_PUBLIC'))
        ->withApiKeyPassword((string) getenv('E_FINANCIALS_API_KEY_PASSWORD'))
        ->make();

    $currencies = $client->currencies()->all();
    expect($currencies)->toBeInstanceOf(CurrenciesListResponse::class)
        ->and($currencies->data)->not->toBeEmpty()
        ->and($currencies->data[0]->id)->toBeString();

    $clients = $client->clients()->all();
    expect($clients)->toBeInstanceOf(ClientsListResponse::class)
        ->and($clients->currentPage)->toBeInt()
        ->and($clients->items)->toBeArray();

    $templates = $client->templates()->all();
    expect($templates)->toBeInstanceOf(TemplatesListResponse::class);

    $vatInfo = $client->bank()->getVatInfo();
    expect($vatInfo)->toBeInstanceOf(VatInfoResponse::class);

    expect($client->accounts()->all())->toBeInstanceOf(AccountsListResponse::class)
        ->and($client->accountDimensions()->all())->toBeInstanceOf(AccountDimensionsListResponse::class)
        ->and($client->bank()->all())->toBeInstanceOf(BankAccountsListResponse::class)
        ->and($client->products()->all())->toBeInstanceOf(ProductsListResponse::class)
        ->and($client->costProfitCentres()->all())->toBeInstanceOf(CostProfitCentresListResponse::class)
        ->and($client->salesArticles()->all())->toBeInstanceOf(SalesArticlesListResponse::class)
        ->and($client->purchaseArticles()->all())->toBeInstanceOf(PurchaseArticlesListResponse::class)
        ->and($client->invoices()->all())->toBeArray()
        ->and($client->invoices()->allSettings())->toBeArray()
        ->and($client->journals()->all())->toBeArray()
        ->and($client->transactions()->all())->toBeArray()
        ->and($client->salesInvoices()->all())->toBeArray()
        ->and($client->purchaseInvoices()->all())->toBeArray();
})->skip(! $hasCredentials, 'Demo API credentials are not configured.');
