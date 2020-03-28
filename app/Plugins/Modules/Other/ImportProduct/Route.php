<?php
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX,
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Modules\Other\ImportProduct\Admin',
    ], 
    function () {
        Route::group(['prefix' => 'import_product'], function () {
            //import products Home
            Route::get('/', 'ImportProductController@index')
            ->name('admin_import_product.index');
            //import products Functions
            Route::post('/infomation', 'ImportProductController@processData')
            ->name('admin_import_product.process');
           Route::post('/description', 'ImportProductController@processDataDescription')
            ->name('admin_import_product.process_description');
            //import categories
            /*            Route::post('/infomation', 'ImportProductController@productCategoryData')
                           ->name('admin_import_product.category');*/


            //common function

            Route::get('/download', 'ImportProductController@exportFormat')
                ->name('admin_import_product.format');
        });

        
    }
);

