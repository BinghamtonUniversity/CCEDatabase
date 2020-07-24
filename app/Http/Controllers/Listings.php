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
        $listing = new Listing();
        $listing->creation_date = Carbon::now();
        $listing->org_code = $organization->org_code;
        $listing->visible = false;
        $listing->update_from_form($request->all());
        return $listing->get_form_data();
    }

    public function update(Request $request, Listing $listing) {
        $listing->org_code = $request->org_code;
        $listing->visible = false;
        $listing->update_from_form($request->all());
        return $listing->get_form_data();
    }

    public function delete(Request $request,Listing $listing){
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
