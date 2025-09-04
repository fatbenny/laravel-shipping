<?php

namespace PangPang\Shipping\Payloads\FedEx\Shipment;

class ShipmentMinimalPayload
{
    public static function build(array $data): array
    {
        return [
            'index' => $data['index'] ?? 'Test' . time(),
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
                'value' => $data['account_number']
            ],
        ];
    }
}