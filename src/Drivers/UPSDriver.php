<?php
namespace PangPang\Shipping\Drivers;

use GuzzleHttp\Client;

class UPSDriver extends AbstractDriver
{
    protected function initializeClient()
    {
        
    }

    public function create(array $data)
    {
       
    }

    public function track(string $trackingNumber)
    {
        
    }

    public function cancel(string $trackingNumber)
    {
        
    }

    public function getRates(array $data)
    {

    }
    // OAuth 流程實作
    protected function getAccessToken()
    {

    }

    protected function buildCreatePayload(array $data)
    {

    }

    protected function handleCreateResponse($response)
    {

    }
    // 實作追蹤回應處理
    protected function handleTrackResponse($response)
    {

    }
    // 實作取消回應處理
    protected function handleCancelResponse($response)
    {

    }
    // 實作費率查詢 payload
    protected function buildRatePayload(array $data)
    {

    }
    // 實作費率查詢回應處理
    protected function handleRateResponse($response)
    {

    }
}
