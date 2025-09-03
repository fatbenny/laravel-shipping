<?php

namespace Pangpang\Shipping;

class ShippingManager
{
    public function test()
    {
        return "Hello from ShippingManager 🚚";
    }

    public function createShipment($data)
    {
        return [
            'status' => 'success',
            'provider' => $data['provider'] ?? 'UPS',
            'tracking_number' => uniqid('TRK')
        ];
    }
}