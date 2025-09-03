<?php

namespace Pangpang\Shipping\Providers;

use Pangpang\Shipping\Contracts\ShippingProvider;
use Illuminate\Support\Facades\Http;

class FedEx implements ShippingProvider
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $accountNumber;
    protected bool $sandbox;

    protected ?string $token = null;

    public function __construct(array $config)
    {
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->accountNumber = $config['account_number'];
        $this->sandbox = $config['sandbox'] ?? false;
    }

    public function authenticate(): string
    {
        if ($this->token) {
            return $this->token;
        }

        $url = $this->sandbox
            ? 'https://apis-sandbox.fedex.com/oauth/token'
            : 'https://apis.fedex.com/oauth/token';

        $response = Http::asForm()->post($url, [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        $data = $response->json();
        $this->token = $data['access_token'] ?? null;

        return $this->token;
    }

    public function createShipment(array $data): array
    {
        $token = $this->authenticate();

        $url = $this->sandbox
            ? 'https://apis-sandbox.fedex.com/ship/v1/shipments'
            : 'https://apis.fedex.com/ship/v1/shipments';

        $response = Http::withToken($token)
            ->post($url, $data);

        return $response->json();
    }

    public function trackShipment(string $trackingNumber): array
    {
        $token = $this->authenticate();

        $url = $this->sandbox
            ? 'https://apis-sandbox.fedex.com/track/v1/trackingnumbers'
            : 'https://apis.fedex.com/track/v1/trackingnumbers';

        $response = Http::withToken($token)
            ->post($url, [
                'trackingInfo' => [
                    [
                        'trackingNumberInfo' => [
                            'trackingNumber' => $trackingNumber
                        ]
                    ]
                ]
            ]);

        return $response->json();
    }
}