<?php

declare(strict_types=1);

namespace EFinancialsClient;

use EFinancialsClient\Contracts\ClientContract;
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
use EFinancialsClient\Contracts\TransporterContract;
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

final class Client implements ClientContract
{
    public function __construct(private readonly TransporterContract $transporter)
    {
        // ..
    }

    public function accountDimensions(): AccountDimensionsContract
    {
        return new AccountDimensions($this->transporter);
    }

    public function accounts(): AccountsContract
    {
        return new Accounts($this->transporter);
    }

    public function bank(): BankContract
    {
        return new Bank($this->transporter);
    }

    public function clients(): ClientsContract
    {
        return new Clients($this->transporter);
    }

    public function costProfitCentres(): CostProfitCentresContract
    {
        return new CostProfitCentres($this->transporter);
    }

    public function currencies(): CurrenciesContract
    {
        return new Currencies($this->transporter);
    }

    public function invoices(): InvoicesContract
    {
        return new Invoices($this->transporter);
    }

    public function journals(): JournalsContract
    {
        return new Journals($this->transporter);
    }

    public function products(): ProductsContract
    {
        return new Products($this->transporter);
    }

    public function purchaseArticles(): PurchaseArticlesContract
    {
        return new PurchaseArticles($this->transporter);
    }

    public function purchaseInvoices(): PurchaseInvoicesContract
    {
        return new PurchaseInvoices($this->transporter);
    }

    public function salesArticles(): SalesArticlesContract
    {
        return new SalesArticles($this->transporter);
    }

    public function salesInvoices(): SalesInvoicesContract
    {
        return new SalesInvoices($this->transporter);
    }

    public function templates(): TemplatesContract
    {
        return new Templates($this->transporter);
    }

    public function transactions(): TransactionsContract
    {
        return new Transactions($this->transporter);
    }
}
