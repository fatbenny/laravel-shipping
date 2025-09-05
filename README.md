# Laravel Shipping (Testing Version)

這是一個基於 **Laravel 11** 的 Shipping 測試專案，目前仍在開發與測試階段。  
⚠️ 注意：此版本僅供測試使用，尚未適合正式環境。

---

## 🚀 環境需求

- PHP >= 8.2
- Composer
- Laravel 11 以上
  
---

##📦 範例用法

# 郵遞區號驗證
```
Route::get('/test-shipping/validate/PostalCode', function () {
    $result = Shipping::driver('fedex')->validate([
        "carrierCode" => "FDXG",
        "countryCode" => "US",
        "stateOrProvinceCode" => "TN",
        "postalCode" => "38116",
        "shipDate" => "2025-09-04",
        "checkForMismatch" => true
    ]);

    return [
        'fedex' => $result
    ];
});
```

# 要求寄件前費率資訊以判斷成本
```
Route::get('/test-shipping/rate', function () {
    $result = Shipping::driver('fedex')->getRates([
        "shipper" => [
            "address" => [
                "postalCode" => "38116",
                "countryCode" => "US",
            ],
        ],
        "recipients" => [
            "address" => [
                "postalCode" => "38116",
                "countryCode" => "US",
            ],
        ],
        "pickupType" => "DROPOFF_AT_FEDEX_LOCATION",
        "rateRequestType" => [
            "ACCOUNT",
            "LIST"
        ],
        'packages' => [
            [
                'weight' => [
                    'units' => 'LB',
                    'value' => '20'
                ],
            ]
        ],
    ]);

    return [
        'fedex' => $result
    ];
});
```

# 建立運送單
```
use PangPang\Shipping\Facades\Shipping;
Route::get('/test-shipping', function () {
    $result = Shipping::driver('fedex')->create([
        "shipper" => [
            "contact" => [
                "personName" => "SENDER NAME",
                "phoneNumber" => "901xxx8595",
            ],
            "address" => [
                "streetLines" => [
                    "SENDER ADDRESS 1",
                ],
                "city" => "MEMPHIS",
                "stateOrProvinceCode" => "TN",
                "postalCode" => "38116",
                "countryCode" => "US",
            ],
        ],
        "recipients" => [
            [
                "contact" => [
                    "personName" => "RECIPIENT NAME",
                    "phoneNumber" => "901xxx8595",
                ],
                "address" => [
                    "streetLines" => [
                        "RECIPIENT ADDRESS 1",
                    ],
                    "city" => "MEMPHIS",
                    "stateOrProvinceCode" => "TN",
                    "postalCode" => "38116",
                    "countryCode" => "US",
                ],
            ],
        ],
        'packages' => [
            [
                'weight' => [
                    'units' => 'LB',
                    'value' => '20'
                ],
            ]
        ],
        'service_type' => 'FEDEX_2_DAY_FREIGHT'
    ]);

    return [
        'fedex' => $result
    ];
});
```

