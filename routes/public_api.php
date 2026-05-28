<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organizations;
use App\Http\Controllers\Listings;
use App\Http\Controllers\Conversations;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SiteConfigurationController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
| All Public API Routes are prepended by /api/public
*/

// Organizations
Route::get('/organizations', [Organizations::class, 'list_all']);
Route::post('/organizations', [Organizations::class, 'admin_add']);
Route::get('/organizations/fields', [Organizations::class, 'fields']);
Route::get('/organization/password/fields', [Organizations::class, 'password_fields']);
Route::get('/organization/register/fields', [Organizations::class, 'get_register_fields']);
Route::get('/organizations/download', [Organizations::class, 'download_orgs']);
Route::get('/ccedb/download_contacts', [Organizations::class, 'download_contacts']);
Route::get('/organizations/{organization}', [Organizations::class, 'get']);
Route::put('/organizations/{organization}/approve', [Organizations::class, 'admin_approve']);
Route::put('/organizations/{organization}', [Organizations::class, 'admin_update']);
Route::put('/organizations/{organization}/reset_password', [Organizations::class, 'password_update']);
Route::delete('/organizations/{organization}', [Organizations::class, 'delete']);
Route::get('/organizations/{organization}/listings', [Organizations::class, 'org_listings']);
Route::get('/organizations/{organization}/impersonate', [Organizations::class, 'impersonate_user']);

// Listings
Route::get('/listings/fields', [Listings::class, 'fields']);
Route::get('/listings', [Listings::class, 'list_all']);
Route::get('/listings/download', [Listings::class, 'listings_download']);
Route::get('/listings/{listing}', [Listings::class, 'get']);
Route::put('/listings/{listing}/approve', [Listings::class, 'admin_approve']);
Route::put('/listings/{listing}', [Listings::class, 'admin_update']);
Route::post('/listings/{organization}', [Listings::class, 'admin_add']);
Route::delete('/listings/{listing}', [Listings::class, 'delete']);

// Conversations
Route::get('/conversations/download', [Conversations::class, 'download_conversations']);
Route::get('/conversations/{conversation}', [Conversations::class, 'get_conversation']);
Route::get('/conversations', [Conversations::class, 'get_all_conversations']);

// Searches
Route::get('/searches/download', [SearchController::class, 'download_searches']);
Route::get('/searches', [SearchController::class, 'get_all_searches']);

// Configurations
Route::put('/configurations/{siteConfiguration}', [SiteConfigurationController::class, 'edit_configuration']);
Route::get('/configurations', [SiteConfigurationController::class, 'get_configurations']);