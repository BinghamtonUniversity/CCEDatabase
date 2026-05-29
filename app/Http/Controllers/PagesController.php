<?php

namespace App\Http\Controllers;

use App\Models\SiteConfiguration;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Organization;
use \Carbon\Carbon;

class PagesController extends Controller
{
    public function home(Request $request) {
        return view('home');
    }
    public function new_listings(Request $request) {
        $listings = Listing::with(['organization'=>function($query){
                $query->where('shown',true);
                $query->where('listed',true);
            }])
            ->where('shown',true)
            ->where('listed',true)
            ->where(function($query) {
                $query->whereNull('end_date');
                $query->orWhere('end_date','>',Carbon::now());
                $query->orWhere('event_type','ongoing');
            })
            ->orderBy('timestamp','desc')
            ->limit(30)->get();

        $modified_listings = [];
        foreach ($listings as $listing){
            if(!is_null($listing->organization)){
                $modified_listings[]= $listing;
            }
        }
        return view('new_listings',[
            'listings'=>$modified_listings
        ]);
    }
    public function listing(Request $request, Listing $listing) {
        if(!$listing->listed || !$listing->shown){
            abort(404);
        }
        $organization = Organization::where('org_code',$listing->org_code)->first();
        return view('listing',[
            'listing'=>$listing,
            'organization'=>$organization,
        ]);
    }
    public function organization(Request $request, Organization $organization) {
        if(!$organization->listed || !$organization->shown){
            abort(404);
        }
        $listings = Listing::where('org_code',$organization->org_code)
            ->where(function($query) {
                $query->whereNull('end_date');
                $query->orWhere('end_date','>',Carbon::now());
                $query->orWhere('event_type','ongoing');
            })->where('shown',true)->where('listed',true)->orderBy('timestamp','desc')->get();
        return view('organization',[
            'organization'=>$organization,
            'listings'=>$listings,
        ]);
    }
    public function organizations(Request $request) {
        $organizations = Organization::select('name','key','fields')->orderBy('name','asc')
            ->where('shown',true)->where('listed',true)->get();
        foreach($organizations as $organization) {
            $letters[strtoupper($organization->name[0])] = true;
        }
        ksort($letters);
        return view('organizations',[
            'organizations'=>$organizations,
            'categories' => config('app.categories'),
            'letters' => array_keys($letters),
        ]);
    }

// PagesController.php

public function sitemap_index() {
    return response()->view('sitemaps.index')->header('Content-Type', 'text/xml');
}

public function sitemap_base() {
    return response()->view('sitemaps.base')->header('Content-Type', 'text/xml');
}

public function sitemap_organizations() {
    $organizations = Organization::select('key', 'timestamp')
        ->where('shown', true)->where('listed', true)
        ->orderBy('timestamp', 'desc')->get();
        
    return response()->view('sitemaps.organizations', compact('organizations'))
        ->header('Content-Type', 'text/xml');
}

public function sitemap_listings() {
    $listings = Listing::select('key', 'timestamp')
        ->where('listed', true)->where('shown', true)
        ->where(function($query) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>', now())
                  ->orWhere('event_type', 'ongoing');
        })->get();

    return response()->view('sitemaps.listings', compact('listings'))
        ->header('Content-Type', 'text/xml');
}}
