<?php

use Illuminate\Http\Request;

// All Public API Routes are prepended by /api/public

// You must authenticate with a valid username / password
// as specified by: API_USER and API_PASS
// in your .env file

// Example:
// API_USER=dev
// API_PASS=dev

//Route::group(['prefix' => 'api'], function () {
    Route::get('/organizations', 'Organizations@list_all');

    Route::post('/organizations', 'Organizations@add');
    Route::get('/organizations/fields', 'Organizations@fields');
//Route::put('/organizations/{organization}', 'Organizations@update');

    Route::get('organizations/{organization}','Organizations@get');
    Route::put('organizations/{organization}','Organizations@admin_update');
    Route::put('/organizations/{organization}/reset_password','Organizations@password_update');
    Route::get('/organizations/{organization}/listings', 'Organizations@org_listings');

//    Route::get('/listings/newListings', 'Listings@get');
    Route::get('/listings', 'Listings@list_all');
    Route::get('/listings/{listing}', 'Listings@get');

    Route::put('/listings/{listing}','Listings@admin_update');
    Route::get('/listings/fields','Listings@fields');
//});

