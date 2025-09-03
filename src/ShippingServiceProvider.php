<?php

namespace PangPang\Shipping;

use Illuminate\Support\ServiceProvider;
use PangPang\Shipping\Drivers\UPSDriver;
use PangPang\Shipping\Drivers\FedExDriver;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('shipping', function ($app) {
            return new ShippingManager($app);
        });

        $this->app->bind('shipping.ups', function ($app) {
            return new UPSDriver(config('shipping.ups'));
        });

        $this->app->bind('shipping.fedex', function ($app) {
            return new FedExDriver(config('shipping.fedex'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/shipping.php' => config_path('shipping.php'),
        ], 'shipping-config');
    }

}