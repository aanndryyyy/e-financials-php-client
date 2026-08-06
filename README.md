# e-Financials (e-Arveldaja) PHP API Client

PHP client for the [e-Arveldaja / e-Financials REST API](https://abiinfo.rik.ee/node/304/).

API docs: [OpenAPI HTML](https://demo-rmp-api.rik.ee/api.html) · [openapi.yaml](https://demo-rmp-api.rik.ee/openapi.yaml)

## Installation

```bash
composer require aanndryyyy/e-financials-php-client guzzlehttp/guzzle
```

This package is PSR-18 based. Provide any PSR-18 HTTP client; Guzzle is the usual choice and is used for discovery when installed.

## Authentication

Generate an API key in e-Arveldaja under **Seadistused → Üldised seadistused**. Each request is signed with:

- `X-AUTH-QUERYTIME` — UTC timestamp (`Y-m-d\TH:i:s`)
- `X-AUTH-KEY` — `{apiKeyPublic}:{BASE64(HMAC-SHA-384("{apiKeyId}:{queryTime}:{path}", apiKeyPassword))}`

## Example

```php
<?php

require 'vendor/autoload.php';

$client = EFinancials::factory()
    ->withApiKeyId('api_key_id')
    ->withApiKeyPublic('api_key_public')
    ->withApiKeyPassword('api_key_password')
    // ->withBaseUri('https://demo-rmp-api.rik.ee') // default demo
    ->make();

$currencies = $client->currencies()->all();
$clients = $client->clients()->all();

print_r($currencies->toArray());
print_r($clients->toArray());
print_r($client->salesInvoices()->all());
print_r($client->journals()->all());
```

Or the shortcut:

```php
$client = EFinancials::client('api_key_id', 'api_key_public', 'api_key_password');
```

## Testing with ClientFake

`ClientFake` implements `ClientContract` by composing the real `Client` with a fake transporter. Queue response DTOs, arrays, JSON strings, or throwables, then assert on exact request paths.

```php
use EFinancialsClient\Responses\Currencies\ListResponse;
use EFinancialsClient\Testing\ClientFake;

$client = new ClientFake([
    ListResponse::fake(),
]);

$response = $client->currencies()->all();
$client->assertSent('currencies');
$client->assertSentTimes('currencies', 1);
```

## Development

Requires PHP 8.2+.

```bash
composer install
composer test         # lint + types + type-coverage + unit
composer lint         # Laravel Pint
composer test:types   # PHPStan
composer test:unit    # Pest 5
composer test:mutate  # Pest mutation testing (requires PCOV/Xdebug)
```

Dev tooling targets PHP 8.4+ (Pest 5). The library runtime still supports PHP 8.2+.

Mutation testing currently applies a local Composer patch for [pestphp/pest#1790](https://github.com/pestphp/pest/issues/1790) (`php-code-coverage` 14 `--coverage-php` format); remove `patches/` once upstream ships the fix.

See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## Available resources

| Accessor | Endpoints |
| --- | --- |
| `clients()` | Clients CRUD, deactivate/reactivate |
| `products()` | Products CRUD, deactivate/reactivate |
| `costProfitCentres()` | Cost/profit centres list |
| `journals()` | Journals CRUD, register/invalidate, files |
| `invoices()` | Invoice series CRUD, invoice settings |
| `bank()` | Bank accounts CRUD, VAT info |
| `accounts()` | Account list |
| `accountDimensions()` | Account dimension list |
| `currencies()` | Currency list |
| `purchaseArticles()` | Purchase article list |
| `salesArticles()` | Sale article list |
| `transactions()` | Transactions CRUD, register/invalidate, files |
| `salesInvoices()` | Sale invoices CRUD, register/invalidate, files, delivery |
| `purchaseInvoices()` | Purchase invoices CRUD, register/invalidate, files |
| `templates()` | Sale invoice templates |

Demo API base URL: `https://demo-rmp-api.rik.ee` (version path `/v1`).

## License

Copyright (c) 2026 Arbictus OÜ.

Dual-licensed. Use it under **either**:

- **[GPL-2.0-or-later](LICENSE)** — free of charge, including for commercial
  companies, as long as you meet the copyleft obligations. This covers
  evaluation, development, internal and hosted use, non-profit and educational
  projects, and distribution within GPL-compatible open source.
- **[A commercial license](LICENSE-COMMERCIAL.md)** — for distributing a
  closed-source product that incorporates this library, or when you need
  warranty and indemnification terms. Contact andry.pedak@arbictus.eu.

You only need the commercial branch if the GPL does not work for you. Running
this library on your own servers is not distribution and triggers no copyleft
obligation.

## Disclaimer

Independent, unofficial client for a public REST API. Not affiliated with,
endorsed by, or supported by Registrite ja Infosüsteemide Keskus (RIK).
