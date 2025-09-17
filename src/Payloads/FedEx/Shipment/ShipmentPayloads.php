<?php

namespace PangPang\Shipping\Payloads\FedEx\Shipment;
use PangPang\Shipping\Payloads\FedEx\Traits\requestedShipmentSpec;
class ShipmentPayloads
{
    use requestedShipmentSpec;
    public static function build(array $data): array
    {

        $shipper = self::formatAddress($data['shipper']);
        $recipient = self::formatAddress($data['recipient']);
        $requested = $data['requested'];
        $packages = self::formatPackages($data['packages']);
        $requestedShipment = [
            'shipper' => $shipper,
            'recipients' => [$recipient],
            'pickupType' => $requested['pickupType'],
            'serviceType' => $requested['serviceType'],
            'packagingType' => $requested['packagingType'],
            'totalPackageCount' => count($packages),
            'requestedPackageLineItems' => $packages,
            'shippingChargesPayment' => [
                'paymentType' => "SENDER"
            ],
            'labelSpecification' => [
                'imageType' => 'PDF',
                'labelStockType'=> 'PAPER_85X11_TOP_HALF_LABEL'
            ]
        ];

        return $requestedShipment;
    }
}