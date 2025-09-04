<?php

namespace PangPang\Shipping\Payloads\FedEx\Rate;

class QuoteRatePayload
{
    public static function build(array $data, array $config): array
    {
        return [
            "accountNumber" => [
                "value" => $config['account_number']
            ],
            "requestedShipment" => [
                "shipper" => $data['shipper'],
                "recipient" => $data['recipients'],
                "pickupType" => "DROPOFF_AT_FEDEX_LOCATION",
                "rateRequestType" => [
                    "ACCOUNT",
                    "LIST"
                ],
                "requestedPackageLineItems" => $data['packages'],
            ]
        ];
    }
}