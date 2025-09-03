<?php

namespace Pangpang\Shipping;

use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerFacades();

        $this->registerPublishables();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * @return void
     */
    protected function registerFacades(): void
    {
        $this->app->singleton('shipping', function () {
            return new ShippingManager();
        });
    }

    /**
     * @return void
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/shipping.php' => config_path('shipping.php')
        ], 'mitrik-shipping-config');
    }

}