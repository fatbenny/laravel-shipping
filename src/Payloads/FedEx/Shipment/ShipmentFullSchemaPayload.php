<?php

namespace PangPang\Shipping\Payloads\FedEx\Shipment;

class ShipmentFullSchemaPayload
{
    public static function build(array $data, array $config): array
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
                'value' => $config['account_number']
            ],
        ];
    }
}