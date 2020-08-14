<?php

namespace App\Http\Controllers;

use App\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Listing;

class Listings extends Controller
{

    public function list_all(Request $request){
        if(isset($request->shown)){
            $listings =  Listing::where('shown',($request->shown==='true')?true:false)->orderBy('creation_date','asc')->get();
        }
        else{
            $listings = Listing::orderBy('creation_date','asc')->get();
        }

        $listings_arr = [];
        foreach($listings as $listing) {
            $listings_arr[]= $listing->get_form_data();
        }

        return $listings_arr;
    }
    public function fields(Request $request) {
        return Listing::get_fields();
    }
    public function get(Request $request,Listing $listing){
        return $listing->get_form_data();
    }


    public function add(Request $request,Organization $organization){
        $listing = new Listing();
        $listing->creation_date = Carbon::now();
        $listing->org_code = $organization->org_code;
        $listing->shown = false;
        $listing->update_from_form($request->all());
        return $listing->get_form_data();
    }

    public function update(Request $request, Listing $listing) {
        $listing->org_code = $request->org_code;
        $listing->shown = false;
        $listing->update_from_form($request->all());
        return $listing->get_form_data();
    }
    public function admin_update(Request $request,Listing $listing){
        $listing->org_code = $request->org_code;
        $listing->update_from_form($request->all());
        if(isset($request->shown)) {
            $listing->update(['shown'=>$request->shown == "1" ? true : false]);
        }

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
