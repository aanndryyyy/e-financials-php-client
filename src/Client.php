<?php

namespace EFinancialsClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private GuzzleClient $httpClient;

    public function __construct(
        ?GuzzleClient $httpClient = null,
        private string $apiKeyId = '',
        private string $apiKeyPublic = '',
        private string $apiKeyPassword = '',
        private string $apiUrl = 'https://demo-rmp-api.rik.ee',
        private string $apiVersion = 'v1'
    ) {
        $this->httpClient = $httpClient ?? new GuzzleClient(
            [
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
    }

    /**
     * Creates authorization key for HTTP header.
     * For more detailed description check e-Financials API doc.
     *
     * @param  string  $path  Relative path of url request.
     * @param  string|null  $queryTime  UTC timestamp used in X-AUTH-QUERYTIME.
     */
    public function createAuthKey(string $path, ?string $queryTime = null): string
    {
        $queryTime ??= $this->createAuthQuerytime();
        $data = $this->apiKeyId.':'.$queryTime.':'.$path;
        $key = $this->apiKeyPassword;

        $requestSignature = base64_encode(hash_hmac('sha384', $data, $key, true));
        $authKey = $this->apiKeyPublic.':'.$requestSignature;

        return $authKey;
    }

    /**
     * Creates current UTC timestamp.
     */
    public function createAuthQuerytime(): string
    {
        return gmdate("Y-m-d\TH:i:s");
    }

    /**
     * The universal request method.
     *
     * @param  string  $method  The HTTP method.
     * @param  string  $endpoint  The relative path of the request.
     * @param  array<string, mixed>  $query  The query parameters.
     * @param  mixed[]  $body  The body. Will be converted to JSON.
     * @return mixed The response as array, error, or null.
     */
    public function request(string $method, string $endpoint, array $query = [], array $body = []): mixed
    {
        $endpoint = '/'.$this->apiVersion.'/'.$endpoint;

        $queryTime = $this->createAuthQuerytime();
        $authKey = $this->createAuthKey($endpoint, $queryTime);
        $headers = [
            'X-AUTH-QUERYTIME' => $queryTime,
            'X-AUTH-KEY' => $authKey,
        ];

        $options = [
            'headers' => $headers,
        ];

        if (count($query) !== 0) {
            $options['query'] = $query;
        }

        if (count($body) !== 0) {
            $options['json'] = $body;
        }

        try {
            $response = $this->httpClient->request($method, $endpoint, $options);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response instanceof ResponseInterface) {
                return $response->getBody()->getContents();
            }

            return null;
        }

        try {
            $result = \json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        } catch (\ValueError $ve) {
            return [
                'internal_error' => $ve->getMessage(),
            ];
        } catch (\JsonException $je) {
            return [
                'internal_error' => $je->getMessage(),
            ];
        }

        return $result;
    }

    public function accountDimensions(): API\AccountDimensions
    {
        return new API\AccountDimensions($this);
    }

    public function accounts(): API\Accounts
    {
        return new API\Accounts($this);
    }

    public function clients(): API\Clients
    {
        return new API\Clients($this);
    }

    public function costProfitCentres(): API\CostProfitCentres
    {
        return new API\CostProfitCentres($this);
    }

    public function currencies(): API\Currencies
    {
        return new API\Currencies($this);
    }

    public function products(): API\Products
    {
        return new API\Products($this);
    }

    public function purchaseArticles(): API\PurchaseArticles
    {
        return new API\PurchaseArticles($this);
    }

    public function salesArticles(): API\SalesArticles
    {
        return new API\SalesArticles($this);
    }

    public function invoices(): API\Invoices
    {
        return new API\Invoices($this);
    }

    public function bank(): API\Bank
    {
        return new API\Bank($this);
    }

    public function journals(): API\Journals
    {
        return new API\Journals($this);
    }

    public function transactions(): API\Transactions
    {
        return new API\Transactions($this);
    }

    public function salesInvoices(): API\SalesInvoices
    {
        return new API\SalesInvoices($this);
    }

    public function purchaseInvoices(): API\PurchaseInvoices
    {
        return new API\PurchaseInvoices($this);
    }

    public function templates(): API\Templates
    {
        return new API\Templates($this);
    }
}
