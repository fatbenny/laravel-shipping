<?php

namespace PangPang\Shipping\Drivers;

use PangPang\Shipping\Contracts\ShippingDriverInterface;
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

    protected function makeRequest($method, $endpoint, $data = [])
    {
        // 共用的 HTTP 請求邏輯
        // 可以使用 Guzzle 或其他 HTTP client
    }

    protected function handleResponse($response)
    {
        // 共用的回應處理邏輯
    }
}