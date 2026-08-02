# e-Financials (e-Arveldaja) PHP API Client

PHP client for the [e-Arveldaja / e-Financials REST API](https://abiinfo.rik.ee/node/304/).

API docs: [OpenAPI HTML](https://demo-rmp-api.rik.ee/api.html) · [openapi.yaml](https://demo-rmp-api.rik.ee/openapi.yaml)

## Installation

```bash
composer require e-financials/php-client
```

## Authentication

Generate an API key in e-Arveldaja under **Seadistused → Üldised seadistused**. Each request is signed with:

- `X-AUTH-QUERYTIME` — UTC timestamp (`Y-m-d\TH:i:s`)
- `X-AUTH-KEY` — `{apiKeyPublic}:{BASE64(HMAC-SHA-384("{apiKeyId}:{queryTime}:{path}", apiKeyPassword))}`

## Example

```php
<?php

require 'vendor/autoload.php';

use EFinancialsClient\Client;

$client = new Client(
    apiKeyId: 'api_key_id',
    apiKeyPublic: 'api_key_public',
    apiKeyPassword: 'api_key_password',
    // apiUrl: 'https://demo-rmp-api.rik.ee', // default demo
);

print_r( $client->clients()->all() );
print_r( $client->salesInvoices()->all() );
print_r( $client->journals()->all() );
print_r( $client->transactions()->all() );
print_r( $client->purchaseInvoices()->all() );
print_r( $client->templates()->all() );
```

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
