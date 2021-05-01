<?php




// Open Routes
Route::prefix('v1.0')->group(function() {


});

// Auth Routes
Route::prefix('v1.0')
    ->middleware(['auth:api', 'suspended'])
    ->group(function () {
    Route::get('me', 'Auth\UserController@index')->name('me');

    // User
    Route::put('user', 'Users\UpdateController')->name('user.update');
    Route::post('user/avatar', 'Users\AvatarController')->name('user.avatar');
    Route::put('user/password', 'Users\PasswordController')->name('user.password');

    // Vendors
    Route::get('vendors', 'Vendors\VendorsController@index')->name('vendors.index');
    Route::get('vendors/{vendor}', 'Vendors\VendorsController@show')->name('vendors.show');
    Route::post('vendors', 'Vendors\VendorsController@store')->name('vendors.store');
    Route::put('vendors/{vendor}', 'Vendors\VendorsController@update')->name('vendors.update')->middleware('can:owner,vendor');

    // Products

    Route::get('products', 'Products\ProductsController@index')->name('products.index');
    Route::post('products', 'Products\ProductsController@store')->name('products.store');
    Route::get('products/{product}', 'Products\ProductsController@show')->name('products.show')->middleware('can:owner,product');
    Route::put('products/{product}', 'Products\ProductsController@update')->name('products.update')->middleware('can:owner,product');
});

// Admin Routes
Route::prefix('v1.0')
    ->middleware(['auth:api', 'verified', 'role:admin'])
    ->group(function () {

    // Users
    Route::apiResource('users', 'UsersController');

    Route::post('users/{user}/suspend', 'UsersController@suspend')->name('users.suspend');
    Route::post('users/{user}/unsuspend', 'UsersController@unsuspend')->name('users.unsuspend');

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'Settings\AdminSettingsController@index');
        Route::get('/{key}', 'Settings\AdminSettingsController@show')->name('setting.show');
        Route::put('/{key}', 'Settings\AdminSettingsController@update')->name('setting.update');
    });
});
