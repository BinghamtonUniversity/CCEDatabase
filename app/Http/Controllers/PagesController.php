<?php

namespace App\Http\Controllers;

use App\SiteConfiguration;
use Illuminate\Http\Request;
use App\Listing;
use App\Organization;
use \Carbon\Carbon;

class PagesController extends Controller
{
    public function home(Request $request) {
        return view('home');
    }
    public function new_listings(Request $request) {
        $listings = Listing::with(['organization'=>function($query){
                $query->where('shown',1);
            }])
            ->where('shown',1)
            ->where(function($query) {
                $query->whereNull('end_date');
                $query->orWhere('end_date','>',Carbon::now());
            })
//            ->whereNotNull('organization')
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
        $organization = Organization::where('org_code',$listing->org_code)->first();
        return view('listing',[
            'listing'=>$listing,
            'organization'=>$organization,
        ]);
    }
    public function organization(Request $request, Organization $organization) {
        $listings = Listing::where('org_code',$organization->org_code)
            ->where(function($query) {
                $query->where('ongoing',true);
                $query->orWhere('end_date','>',Carbon::now());
            })->get();
        return view('organization',[
            'organization'=>$organization,
            'listings'=>$listings,
        ]);
    }
    public function organizations(Request $request) {
        $organizations = Organization::select('name','key','fields')
            ->where('shown',true)->get();
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
}
