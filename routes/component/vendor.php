<?php
$prefixVendor = sc_config('PREFIX_VENDOR')??'vendor';

Route::group(['prefix' => $prefixVendor], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@getVendors')->name('vendors');
    $router->get('/{name}_{id}', 'ShopFront@productToVendor')
        ->where(['id' => '[0-9]+'])->name('vendor');
});