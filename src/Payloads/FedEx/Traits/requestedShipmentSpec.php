<?php
namespace PangPang\Shipping\Payloads\FedEx\Traits;
trait requestedShipmentSpec
{
    private static function formatAddress(array $info): array
    {
        $address = $info["address"];
        $contact = $info["contact"];
        //$tins = $shipper["tins"]; 暫時停用

        return [
            'address' => [
                'streetLines' => [
                    $address['streetLines'][0] ?? '',
                    $address['streetLines'][1] ?? '',
                ],
                'city' => $address['city'] ?? '',
                'stateOrProvinceCode' => $address['stateOrProvinceCode'] ?? '',
                'postalCode' => $address['postalCode'] ?? '',
                'countryCode' => $address['countryCode'] ?? '',
                'residential' => $address['residential'] ?? '',
            ],
            'contact' => [
                'personName' => $contact['personName'] ?? '',
                'emailAddress' => $contact['emailAddress'] ?? '',
                'phoneExtension' => $contact['phoneExtension'] ?? '',
                'phoneNumber' => $contact['phoneNumber'] ?? '',
                'companyName' => $contact['companyName'] ?? '',
            ]
        ];
    }
    private static function formatPackages(array $packages): array
    {
        $result = [];
        if (isset($packages['weight'], $packages['length'], $packages['width'], $packages['height'])) {
            $packages = [$packages];
        }

        foreach ($packages as $package) {
            $packageData = [
                'dimensions' => [
                    'units' => $package['dimensions_units'] ?? 'IN',
                    'length' => $package['length'],
                    'width' => $package['width'],
                    'height' => $package['height'],
                ],
                'weight' => [
                    'units' => $package['weight_units'] ?? 'LB',
                    'value' => $package['weight']
                ]
            ];
            $result[] = $packageData;
        }

        return $result;
    }
}