<?php

namespace PangPang\Shipping;

use Illuminate\Foundation\Application;
use InvalidArgumentException;

class ShippingManager
{
    protected $app;
    protected $drivers = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        if (!isset($this->drivers[$name])) {
            $this->drivers[$name] = $this->createDriver($name);
        }

        return $this->drivers[$name];
    }

    protected function createDriver($name)
    {
        $method = 'create' . ucfirst($name) . 'Driver';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw new InvalidArgumentException("Driver [{$name}] not supported.");
    }

    protected function createUpsDriver()
    {
        return $this->app->make('shipping.ups');
    }

    protected function createFedexDriver()
    {
        return $this->app->make('shipping.fedex');
    }

    protected function getDefaultDriver()
    {
        return config('shipping.default', 'fedex');
    }

    // Magic methods for easy access
    public function __get($name)
    {
        return $this->driver(strtolower($name));
    }

    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}