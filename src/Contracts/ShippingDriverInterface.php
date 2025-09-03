<?php
namespace PangPang\Shipping\Contracts;

interface ShippingDriverInterface
{
    public function create(array $data);
    public function track(string $trackingNumber);
    public function cancel(string $trackingNumber);
    public function getRates(array $data);
}