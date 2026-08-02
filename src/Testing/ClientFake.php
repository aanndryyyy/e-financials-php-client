<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing;

use EFinancialsClient\Client;
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
use EFinancialsClient\ValueObjects\Transporter\Payload;
use EFinancialsClient\ValueObjects\Transporter\Response;
use PHPUnit\Framework\Assert as PHPUnit;
use Throwable;

final class ClientFake implements ClientContract
{
    private readonly TransporterFake $transporter;

    private readonly Client $client;

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function __construct(array $responses = [])
    {
        $this->transporter = new TransporterFake($responses);
        $this->client = new Client($this->transporter);
    }

    /**
     * @param  array<int, ResponseContract|array<array-key, mixed>|string|Throwable>  $responses
     */
    public function addResponses(array $responses): void
    {
        $this->transporter->addResponses($responses);
    }

    /**
     * @return array<int, Payload>
     */
    public function recorded(): array
    {
        return $this->transporter->recorded();
    }

    /**
     * @return array<int, array{0: Payload, 1: Response}>
     */
    public function recordedPairs(): array
    {
        return $this->transporter->recordedPairs();
    }

    public function assertSent(string $resource, callable|int|null $callback = null): void
    {
        if (is_int($callback)) {
            $this->assertSentTimes($resource, $callback);

            return;
        }

        PHPUnit::assertTrue(
            $this->sent($resource, $callback) !== [],
            "The expected [{$resource}] request was not sent."
        );
    }

    public function assertSentTimes(string $resource, int $times, ?callable $callback = null): void
    {
        $count = count($this->sent($resource, $callback));

        PHPUnit::assertSame(
            $times,
            $count,
            "The expected [{$resource}] request was sent {$count} times instead of {$times} times."
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
        $resources = array_map(
            static fn (Payload $payload): string => $payload->resource(),
            $this->transporter->recorded(),
        );

        PHPUnit::assertEmpty(
            $resources,
            'The following requests were sent unexpectedly: '.implode(', ', $resources)
        );
    }

    /**
     * @return array<int, Payload>
     */
    private function sent(string $resource, ?callable $callback = null): array
    {
        $callback ??= static fn (Payload $payload): bool => true;
        $expected = ltrim($resource, '/');

        return array_values(array_filter(
            $this->transporter->recorded(),
            static function (Payload $payload) use ($expected, $callback): bool {
                if (ltrim($payload->resource(), '/') !== $expected) {
                    return false;
                }

                return $callback($payload);
            },
        ));
    }

    public function accountDimensions(): AccountDimensionsContract
    {
        return $this->client->accountDimensions();
    }

    public function accounts(): AccountsContract
    {
        return $this->client->accounts();
    }

    public function bank(): BankContract
    {
        return $this->client->bank();
    }

    public function clients(): ClientsContract
    {
        return $this->client->clients();
    }

    public function costProfitCentres(): CostProfitCentresContract
    {
        return $this->client->costProfitCentres();
    }

    public function currencies(): CurrenciesContract
    {
        return $this->client->currencies();
    }

    public function invoices(): InvoicesContract
    {
        return $this->client->invoices();
    }

    public function journals(): JournalsContract
    {
        return $this->client->journals();
    }

    public function products(): ProductsContract
    {
        return $this->client->products();
    }

    public function purchaseArticles(): PurchaseArticlesContract
    {
        return $this->client->purchaseArticles();
    }

    public function purchaseInvoices(): PurchaseInvoicesContract
    {
        return $this->client->purchaseInvoices();
    }

    public function salesArticles(): SalesArticlesContract
    {
        return $this->client->salesArticles();
    }

    public function salesInvoices(): SalesInvoicesContract
    {
        return $this->client->salesInvoices();
    }

    public function templates(): TemplatesContract
    {
        return $this->client->templates();
    }

    public function transactions(): TransactionsContract
    {
        return $this->client->transactions();
    }
}
