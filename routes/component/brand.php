<?php
$prefixBrand = sc_config('PREFIX_BRAND')??'brand';

Route::group(['prefix' => $prefixBrand], function ($router) use($suffix) {
    $router->get('/', 'ShopFront@getBrands')->name('brands');
    $router->get('/{name}_{id}', 'ShopFront@productToBrand')
        ->where(['id' => '[0-9]+'])->name('brand');
});