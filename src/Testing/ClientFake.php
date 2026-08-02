<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing;

use EFinancialsClient\Contracts\ClientContract;
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

    public function accountDimensions(): AccountDimensions
    {
        return new AccountDimensions($this->transporter);
    }

    public function accounts(): Accounts
    {
        return new Accounts($this->transporter);
    }

    public function bank(): Bank
    {
        return new Bank($this->transporter);
    }

    public function clients(): Clients
    {
        return new Clients($this->transporter);
    }

    public function costProfitCentres(): CostProfitCentres
    {
        return new CostProfitCentres($this->transporter);
    }

    public function currencies(): Currencies
    {
        return new Currencies($this->transporter);
    }

    public function invoices(): Invoices
    {
        return new Invoices($this->transporter);
    }

    public function journals(): Journals
    {
        return new Journals($this->transporter);
    }

    public function products(): Products
    {
        return new Products($this->transporter);
    }

    public function purchaseArticles(): PurchaseArticles
    {
        return new PurchaseArticles($this->transporter);
    }

    public function purchaseInvoices(): PurchaseInvoices
    {
        return new PurchaseInvoices($this->transporter);
    }

    public function salesArticles(): SalesArticles
    {
        return new SalesArticles($this->transporter);
    }

    public function salesInvoices(): SalesInvoices
    {
        return new SalesInvoices($this->transporter);
    }

    public function templates(): Templates
    {
        return new Templates($this->transporter);
    }

    public function transactions(): Transactions
    {
        return new Transactions($this->transporter);
    }
}
