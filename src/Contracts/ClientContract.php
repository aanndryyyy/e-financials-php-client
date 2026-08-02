<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts;

use EFinancialsClient\Contracts\Resources\AccountDimensionsContract;
use EFinancialsClient\Contracts\Resources\AccountsContract;
use EFinancialsClient\Contracts\Resources\BankContract;
use EFinancialsClient\Contracts\Resources\ClientsContract;
use EFinancialsClient\Contracts\Resources\CostProfitCentresContract;
use EFinancialsClient\Contracts\Resources\CurrenciesContract;
use EFinancialsClient\Contracts\Resources\InvoicesContract;
use EFinancialsClient\Contracts\Resources\JournalsContract;
use EFinancialsClient\Contracts\Resources\ProductsContract;
use EFinancialsClient\Contracts\Resources\PurchaseArticlesContract;
use EFinancialsClient\Contracts\Resources\PurchaseInvoicesContract;
use EFinancialsClient\Contracts\Resources\SalesArticlesContract;
use EFinancialsClient\Contracts\Resources\SalesInvoicesContract;
use EFinancialsClient\Contracts\Resources\TemplatesContract;
use EFinancialsClient\Contracts\Resources\TransactionsContract;

interface ClientContract
{
    public function accountDimensions(): AccountDimensionsContract;

    public function accounts(): AccountsContract;

    public function bank(): BankContract;

    public function clients(): ClientsContract;

    public function costProfitCentres(): CostProfitCentresContract;

    public function currencies(): CurrenciesContract;

    public function invoices(): InvoicesContract;

    public function journals(): JournalsContract;

    public function products(): ProductsContract;

    public function purchaseArticles(): PurchaseArticlesContract;

    public function purchaseInvoices(): PurchaseInvoicesContract;

    public function salesArticles(): SalesArticlesContract;

    public function salesInvoices(): SalesInvoicesContract;

    public function templates(): TemplatesContract;

    public function transactions(): TransactionsContract;
}
