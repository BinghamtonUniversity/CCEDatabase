<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organization;
use App\Listing;

class Organizations extends Controller
{
    public function fetch_list(Request $request) {
        $organizations = Organization::select('name','key')
            ->orderBy('name')->get();
        $organizations_arr = [];
        foreach($organizations as $organization) {
            $organizations_arr[] = [
                'label' => $organization->name,
                'value' => $organization->key,
            ];
        }
        return $organizations_arr;
    }
    public function fields(Request $request) {
        return Organization::get_fields();
    }

    public static function add(Request $request){
        $organization = new Organization();
        $organization->save();
        $organization->org_code = $organization->key;
        $organization->passcode = sha1($request->passcode);
        $organization->update_from_form($request->all());
        return $organization->get_form_data();
    }

    public function get(Request $request, Organization $organization) {
        return $organization->get_form_data();
    }

    public function update(Request $request, Organization $organization) {
        $organization->update_from_form($request->all());
        $organization->shown = false;
        return $organization->get_form_data();
    }

    public function delete(Request $request, Organization $organization){
        if($organization->delete()){
            return "Successfully Deleted!";
        } else{
            return "Failed to delete";
        }
    }

    public function password_update(Request $request,Organization $organization){
        if ($organization->update(['passcode'=>sha1($request->passcode)])) {
            return "Successfully updated the password";
        } else{
            return "Failed to update the password!";
        }
    }

    public function org_listings(Request $request, Organization $organization) {
        $listings = Listing::where('org_code',$organization->org_code)->get();
        $modified_results = [];
        foreach ($listings as $listing) {
            $modified_results[] = $listing->get_form_data();
        }
        return $modified_results;
    }
}
