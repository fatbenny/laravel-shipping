<?php

namespace PangPang\Shipping\Payloads\FedEx\Validate;

class ValidatePostalPayload
{
    public static function build(array $data, array $config): array
    {
        return [
            "carrierCode" => $data['carrierCode'],
            "countryCode" => $data['countryCode'],
            "stateOrProvinceCode" => $data['stateOrProvinceCode'],
            "postalCode" => $data['postalCode'],
            "shipDate" => $data['shipDate'],
            "checkForMismatch" => $data['checkForMismatch'],
        ];
    }
}