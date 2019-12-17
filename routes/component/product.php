<?php
Route::group(['prefix' => 'product'], function ($router) {
    $router->get('/', 'ShopFront@allProducts')->name('product.all');
    $router->post('/info', 'ShopFront@productInfo')
        ->name('product.info');
    $router->get('/{alias}.{suffix?}', 'ShopFront@productDetail')
        ->name('product.detail');
});