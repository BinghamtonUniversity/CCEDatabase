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
    public function get(Request $request, Organization $organization) {
        return $organization;
    }
    public function update(Request $request, Organization $organization) {
        $organization->update($request->all());
        $organization->shown = false;
        return $organization;
    }
    public function org_listings(Request $request, Organization $organization) {
        $listings = Listing::where('org_code',$organization->org_code)->get();
        return $listings;
    }

}
