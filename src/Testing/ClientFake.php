<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing;

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
use EFinancialsClient\Contracts\ResponseContract;
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
use EFinancialsClient\ValueObjects\Transporter\Payload;
use PHPUnit\Framework\Assert as PHPUnit;
use Throwable;

final class ClientFake implements ClientContract
{
    private TransporterFake $transporter;

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function __construct(array $responses = [])
    {
        $this->transporter = new TransporterFake($responses);
    }

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function addResponses(array $responses): void
    {
        $this->transporter->addResponses($responses);
    }

    public function assertSent(string $resource, ?callable $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->sent($resource, $callback) !== [],
            "The expected [{$resource}] request was not sent."
        );
    }

    public function assertNotSent(string $resource, ?callable $callback = null): void
    {
        PHPUnit::assertCount(
            0,
            $this->sent($resource, $callback),
            "The unexpected [{$resource}] request was sent."
        );
    }

    public function assertNothingSent(): void
    {
        PHPUnit::assertEmpty($this->transporter->recorded(), 'Unexpected requests were sent.');
    }

    /**
     * @return array<int, Payload>
     */
    private function sent(string $resource, ?callable $callback = null): array
    {
        $callback ??= static fn (Payload $payload): bool => true;

        return array_values(array_filter(
            $this->transporter->recorded(),
            static function (Payload $payload) use ($resource, $callback): bool {
                if (! str_starts_with(ltrim($payload->resource(), '/'), ltrim($resource, '/'))) {
                    return false;
                }

                return $callback($payload);
            },
        ));
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
