<?php

namespace PangPang\Shipping\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;

class FedExDriver extends AbstractDriver
{
    protected function initializeClient()
    {
        $this->client = new Client([
            'base_uri' => $this->config['base_uri'] ?? 'https://apis-sandbox.fedex.com/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'X-locale' => 'en_US',
            ],
        ]);
    }
    protected function getAccessToken(): string
    {
        return Cache::remember('fedex_access_token', 3600, function () {
            $authClient = new Client([
                'base_uri' => $this->config['base_uri'] ?? 'https://apis-sandbox.fedex.com/',
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            ]);

            $response = $authClient->post('oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret'],
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            return $data['access_token'];
        });
    }
    protected function buildCreatePayload(array $data)
    {
        return [
            'index' => $data['index'] ?? 'Test' . time(),
            // 'labelResponseOptions' => 'URL_ONLY',
            'requestedShipment' => [
                'shipper' => $data['shipper'],
                'recipients' => $data['recipients'],
                'serviceType' => $data['service_type'] ?? 'FEDEX_2_DAY_FREIGHT',
                'packagingType' => 'YOUR_PACKAGING',
                'pickupType' => "DROPOFF_AT_FEDEX_LOCATION",
                'shippingChargesPayment' => [
                    'paymentType' => 'SENDER'
                ],
                'requestedPackageLineItems' => $data['packages'],
            ],
            'accountNumber' => [
                'value' => $this->config['account_number']
            ],
        ];
    }
    public function create(array $data)
    {
        $payload = $this->buildCreatePayload($data);
        $response = $this->client->post('ship/v1/openshipments/create', [
            'json' => $payload
        ]);
        return $this->handleCreateResponse($response);
    }
    protected function handleCreateResponse($response)
    {
        $data = json_decode($response->getBody(), true);
        dd($data);
        return [
            'success' => true,
            'provider' => 'FedEx',
            'tracking_number' => $data['output']['transactionShipments'][0]['masterTrackingNumber'],
            // 'label_url' => $data['output']['transactionShipments'][0]['pieceResponses'][0]['packageDocuments'][0]['url'],
            'raw_response' => $data
        ];
    }


    //郵遞區號驗證功能會驗證國家/地區與城市的郵遞區號，並會在回應中提供經過驗證的郵遞區號。
    public function validate(array $data)
    {
        try {
            $response = $this->client->post('country/v1/postal/validate', [
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode((string) $response->getBody(), true);

            return [
                'status' => $statusCode,
                'data' => $body,
            ];

        } catch (RequestException $e) {
            return [
                'status' => $e->getResponse()->getStatusCode(),
                'error' => json_decode((string) $e->getResponse()->getBody(), true)
            ];
        }
    }
    public function track(string $trackingNumber)
    {
        $response = $this->client->post('track/v1/trackingnumbers', [
            'json' => [
                'includeDetailedScans' => true,
                'trackingInfo' => [
                    [
                        'trackingNumberInfo' => [
                            'trackingNumber' => $trackingNumber
                        ]
                    ]
                ]
            ]
        ]);

        return $this->handleTrackResponse($response);
    }

    public function cancel(string $trackingNumber)
    {
        // FedEx 取消實作
    }

    public function getRates(array $data)
    {
        $payload = $this->buildRatePayload($data);

        $response = $this->client->post('rate/v1/rates/quotes', [
            'json' => $payload
        ]);

        return $this->handleRateResponse($response);
    }
    protected function handleTrackResponse($response)
    {
        // 實作追蹤回應處理
    }

    protected function handleCancelResponse($response)
    {
        // 實作取消回應處理
    }

    protected function buildRatePayload(array $data)
    {
        // 實作費率查詢 payload
    }

    protected function handleRateResponse($response)
    {
        // 實作費率查詢回應處理
    }
}