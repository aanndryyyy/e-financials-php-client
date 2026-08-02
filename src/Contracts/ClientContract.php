<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts;

use EFinancialsClient\Resources\AccountDimensions;
use EFinancialsClient\Resources\Accounts;
use EFinancialsClient\Resources\Bank;
use EFinancialsClient\Resources\Clients;
use EFinancialsClient\Resources\CostProfitCentres;
use EFinancialsClient\Resources\Currencies;
use EFinancialsClient\Resources\Invoices;
use EFinancialsClient\Resources\Journals;
use EFinancialsClient\Resources\Products;
use EFinancialsClient\Resources\PurchaseArticles;
use EFinancialsClient\Resources\PurchaseInvoices;
use EFinancialsClient\Resources\SalesArticles;
use EFinancialsClient\Resources\SalesInvoices;
use EFinancialsClient\Resources\Templates;
use EFinancialsClient\Resources\Transactions;

interface ClientContract
{
    public function accountDimensions(): AccountDimensions;

    public function accounts(): Accounts;

    public function bank(): Bank;

    public function clients(): Clients;

    public function costProfitCentres(): CostProfitCentres;

    public function currencies(): Currencies;

    public function invoices(): Invoices;

    public function journals(): Journals;

    public function products(): Products;

    public function purchaseArticles(): PurchaseArticles;

    public function purchaseInvoices(): PurchaseInvoices;

    public function salesArticles(): SalesArticles;

    public function salesInvoices(): SalesInvoices;

    public function templates(): Templates;

    public function transactions(): Transactions;
}
