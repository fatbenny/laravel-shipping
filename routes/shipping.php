<?php

use Illuminate\Support\Facades\Route;
use PangPang\Shipping\Controllers\FedExTestController;

Route::prefix('shipping')->group(function () {
    Route::get('/index', function() {
        return view('shipping::fedex.index');
    });
    Route::post('/createLabel', [FedExTestController::class, 'createLabel'])->name('shipping.fedex.create');
    Route::post('/createReturnLabel', [FedExTestController::class, 'createReturnLabel'])->name('shipping.fedex.createReturn');
});