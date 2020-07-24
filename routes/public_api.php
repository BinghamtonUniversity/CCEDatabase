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
Route::post('/organizations', 'Organizations@add');
Route::get('/organizations/fields', 'Organizations@fields');
Route::put('/organizations/{organization}', 'Organizations@update');
Route::get('/organizations/{organization}/listings', 'Organizations@org_listings');
