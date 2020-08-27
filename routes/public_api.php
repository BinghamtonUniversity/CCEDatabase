<?php

use Illuminate\Http\Request;

// All Public API Routes are prepended by /api/public

// You must authenticate with a valid username / password
// as specified by: API_USER and API_PASS
// in your .env file

// Example:
// API_USER=dev
// API_PASS=dev

Route::get('/organizations', 'Organizations@list_all');
Route::post('/organizations', 'Organizations@admin_add');
Route::get('/organizations/fields', 'Organizations@fields');
Route::get('/organization/password/fields','Organizations@password_fields');
Route::get('/organization/register/fields','Organizations@get_register_fields');
Route::get('/ccedb/download_contacts','Organizations@download_contacts');
Route::get('/organizations/{organization}','Organizations@get');
Route::put('/organizations/{organization}/approve','Organizations@admin_approve');
Route::put('/organizations/{organization}','Organizations@admin_update');
Route::put('/organizations/{organization}/reset_password','Organizations@password_update');

Route::delete('/organizations/{organization}','Organizations@delete');
Route::get('/organizations/{organization}/listings', 'Organizations@org_listings');

Route::get('/listings/fields','Listings@fields');
Route::get('/listings', 'Listings@list_all');
Route::get('/listings/{listing}', 'Listings@get');
Route::put('/listings/{listing}/approve','Listings@admin_approve');
Route::put('/listings/{listing}','Listings@admin_update');
Route::post('/listings/{organization}', 'Listings@admin_add');
Route::delete('/listings/{listing}','Listings@delete');

