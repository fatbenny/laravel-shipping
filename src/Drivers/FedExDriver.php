<?php

namespace PangPang\Shipping\Drivers;

use PangPang\Shipping\Payloads\FedEx\Rate\QuoteRatePayload;
use PangPang\Shipping\Payloads\FedEx\Shipment\ShipmentPayloads;
use PangPang\Shipping\Payloads\FedEx\Validate\ValidatePostalPayload;
use PangPang\Shipping\Responses\ShippingResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class FedExDriver extends AbstractDriver
{
    private $test_url = 'https://apis-sandbox.fedex.com';
    private $live_url = 'https://apis.fedex.com';
    private const Carriers = 'FedEx';
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
    public function createShipment(array $data)
    {
        $payload['requestedShipment'] = ShipmentPayloads::build($data);
        $payload['labelResponseOptions'] = $data['labelResponseOptions'] ?? 'URL_ONLY';

        if ($data['labelResponseOptions'] == 'LABEL') {
            $payload['openShipmentAction'] = 'PROVIDE_DOCUMENTS_INCREMENTALLY';
        }
        return $this->makeRequest('post', '/ship/v1/shipments', $payload);
    }
    //郵遞區號驗證功能會驗證國家/地區與城市的郵遞區號，並會在回應中提供經過驗證的郵遞區號。
    public function validate(array $data)
    {
        try {
            $payload = ValidatePostalPayload::build($data, $this->config);
            $response = $this->client->post('country/v1/postal/validate', [
                'json' => $payload,
            ]);
            return ShippingResponse::success($response);

        } catch (RequestException $e) {
            return ShippingResponse::error($e);
        }
    }
    //要求寄件前費率資訊以判斷成本。 
    public function getRates(array $data)
    {
        try {
            $payload = QuoteRatePayload::build($data, $this->config);
            $response = $this->client->post('rate/v1/rates/quotes', [
                'json' => $payload,
            ]);
            return ShippingResponse::success($response);

        } catch (RequestException $e) {
            return ShippingResponse::error($e);
        }
    }
    protected function buildRatePayload(array $data)
    {
        // 實作費率查詢 payload
    }
}