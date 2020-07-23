<?php

namespace App\Http\Controllers;

use App\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Listing;

class Listings extends Controller
{

    public function get(Request $request, Listing $listing) {
        return $listing;
    }
    public function add(Request $request,Organization $organization){
        $modified_request =  Listing::modifyListing($request,$organization->org_code);
        $listing =  new Listing($modified_request);
        $listing->visible = false;
        $listing->creation_date = Carbon::now();
        $listing->save();
        return $listing;
    }

    public function update(Request $request, Listing $listing) {
//        dd($listing);
//        $listing->updateListing($request,$request->org_code);
        $listing = $listing->updateListing($request,$request->org_code);
        return (array)($listing->getAttributes());
    }

    public function delete(Request $request,Listing $listing){
//        return $listing->key;
        if($listing->delete()) {
            return "Success";
        }
        else{
            return "Failed";
        }
    }
    public function fetch_list(Request $request) {
        $listings = Listing::select('title','key')->orderBy('title')->get();

        $listings_arr = [];
        foreach($listings as $listing) {
            $listings_arr[] = [
                'label' => $listing->title,
                'value' => $listing->key,
            ];
        }
        return $listings_arr;
    }
}
