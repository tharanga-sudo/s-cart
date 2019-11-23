<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\Paypal\Controllers',
    ], function () {
        Route::get('paypal', 'PayPalController@index')
            ->name('paypal.index');
        Route::get('return/{order_id}', 'PayPalController@getReturn')
            ->name('paypal.return');
    });
