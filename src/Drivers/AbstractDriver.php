<?php

namespace PangPang\Shipping\Drivers;

use PangPang\Shipping\Contracts\ShippingDriverInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
abstract class AbstractDriver implements ShippingDriverInterface
{
    protected $config;
    protected $client;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->initializeClient();
    }

    abstract protected function initializeClient();

    protected function makeRequest($method, $endpoint, $payload = [])
    {
        try {
            $payload['accountNumber'] = ['value' => $this->config['account_number']];
            switch ($method) {
                case 'post':
                    $response = $this->client->post($endpoint, ['json' => $payload]);
                    break;
                case 'put':
                    $response = $this->client->put($endpoint, ['json' => $payload]);
                    break;
            }
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('Failed to get FedEx: ' . $e->getMessage());
        }
    }

    protected function handleResponse($response)
    {
        // 共用的回應處理邏輯
    }
}