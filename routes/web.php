<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@home');
Route::get('/listings/new', 'PagesController@new_listings');
Route::get('/listings/{listing}', 'PagesController@listing');
Route::get('/organizations/{organization}', 'PagesController@organization');
Route::get('/organizations', 'PagesController@organizations');
Route::get('/search', 'SearchController@search_page');
Route::get('/search/results', 'SearchController@search_results_page');
Route::get('/search/google', 'SearchController@google_search_results_page');
Route::get('/search/google/iframe', 'SearchController@google_search_results_iframe');
Route::get('/manage/login', 'OrgAdmin@login');
Route::get('/manage/logout', 'OrgAdmin@logout');
Route::get('/manage', 'OrgAdmin@manage');


Route::group(['prefix' => 'api'], function () {
    Route::get('/search', 'SearchController@advanced_search');

    Route::get('/listings/list', 'Listings@fetch_list');
    Route::get('/listings/fields', 'Listings@fields');
    Route::get('/listings/{listing}', 'Listings@get');
    Route::post('/listings/{organization}', 'Listings@add');
    Route::put('/listings/{listing}', 'Listings@update');
    Route::delete('/listings/{listing}', 'Listings@delete');

    Route::put('/password_update/{organization}', 'Organizations@password_update');
    Route::get('/organizations/list', 'Organizations@fetch_list');
    Route::get('/organizations/fields', 'Organizations@fields');
    Route::get('/organizations/{organization}/listings', 'Organizations@org_listings');
    Route::get('/organizations/{organization}', 'Organizations@get');
    Route::put('/organizations/{organization}', 'Organizations@update');
    Route::post('/orgauth/authenticate', 'OrgAdmin@authenticate');
    Route::post('/orgauth/register', 'OrgAdmin@register');
});

