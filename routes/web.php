<?php

use Illuminate\Support\Facades\Route;

// Import your Controllers
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OrgAdmin;
use App\Http\Controllers\Listings;
use App\Http\Controllers\Organizations;
use App\Http\Controllers\Conversations;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Pages
Route::get('/', [PagesController::class, 'home'])->name('home_page');
Route::get('/newlistings', [PagesController::class, 'new_listings'])->name('newlistings_page');
Route::get('/listings/{listing}', [PagesController::class, 'listing']);
Route::get('/organizations/{organization}', [PagesController::class, 'organization']);
Route::get('/organizations', [PagesController::class, 'organizations'])->name('organizations_page');
Route::get('/sitemap.xml', [PagesController::class, 'sitemap']);

// Search
Route::get('/search', [SearchController::class, 'search_page'])->name('search_page');
Route::get('/search/results', [SearchController::class, 'search_results_page']);
Route::get('/search/google', [SearchController::class, 'google_search_results_page']);
Route::get('/search/google/iframe', [SearchController::class, 'google_search_results_iframe']);

// Management / Auth
Route::get('/manage/login', [OrgAdmin::class, 'login']);
Route::get('/manage/logout', [OrgAdmin::class, 'logout']);
Route::get('/manage', [OrgAdmin::class, 'manage'])->name('manage_page');
Route::get('/manage/{password}', [OrgAdmin::class, 'password_reset']);

// API Group
Route::group(['prefix' => 'api'], function () {
    Route::get('/search', [SearchController::class, 'advanced_search']);

    Route::get('/listings/list', [Listings::class, 'fetch_list']);
    Route::get('/listings/fields', [Listings::class, 'fields']);
    Route::get('/listings/{listing}', [Listings::class, 'get']);
    Route::post('/listings/{organization}', [Listings::class, 'add']);
    Route::put('/listings/{listing}', [Listings::class, 'update']);
    Route::delete('/listings/{listing}', [Listings::class, 'delete']);

    Route::put('/password_update/{organization}', [Organizations::class, 'password_update']);
    Route::get('/organizations/list', [Organizations::class, 'fetch_list']);
    Route::get('/organizations/fields', [Organizations::class, 'fields']);
    Route::get('/organizations/{organization}/listings', [Organizations::class, 'org_listings']);
    Route::get('/organizations/{organization}', [Organizations::class, 'get']);
    Route::put('/organizations/{organization}', [Organizations::class, 'update']);

    Route::post('/orgauth/authenticate', [OrgAdmin::class, 'authenticate']);
    Route::post('/orgauth/register', [OrgAdmin::class, 'register']);

    Route::post('/password/{organization}', [Organizations::class, 'password_request']);

    Route::post('/conversations/listing/{listing}', [Conversations::class, 'add_listing_conversation']);
    Route::post('/conversations/organization/{organization}', [Conversations::class, 'add_org_conversation']);
    Route::get('/conversations/{conversation}', [Conversations::class, 'get_conversation']);
    Route::get('/conversations', [Conversations::class, 'get_all_conversations']);
});