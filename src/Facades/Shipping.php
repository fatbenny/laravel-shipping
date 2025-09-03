<?php
namespace Pangpang\Shipping\Facades;

use Illuminate\Support\Facades\Facade;

class Shipping extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Shipping';
    }
}