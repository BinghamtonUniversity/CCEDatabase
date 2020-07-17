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
        $modifed_request =  Organizations::modify_register_request($request);
        $organization = new Organization($modifed_request);
        $organization->org_code = $organization->key;
        $organization->save();
        return $organization;
    }

    public function get(Request $request, Organization $organization) {
        return $this->modify_output($organization);
//        return $organization;
    }
    public function update(Request $request, Organization $organization) {
        return $this->modify_request($request);
//        $organization->update($this->modify_request($request));
//        $organization->shown = false;
//        return $organization;
    }

    public function password_update(Request $request,Organization $organization){
        if ($organization->update(['passcode'=>sha1($request->passcode)])) {
            return "Successfully updated the password";
        }
        else{
            return "Failed to update the password!";
        }
//        return $organization;
    }

    public function org_listings(Request $request, Organization $organization) {
        $listings = Listing::where('org_code',$organization->org_code)->get();

        if(is_array($listings)) {
            $modified_results = [];
            foreach ($listings as $listing) {
                $modified_results[] = Listings::modify_output($listing);
            }
        }else{
            return Listings::modify_output($listings);
        }
        return $modified_results;
    }
    static public function modify_output($organization){
        return [
            'key'=>$organization->key,
            'org_code'=>$organization->org_code,
            "organization_information"=>[
                'name'=>$organization->name,
                'address1'=>$organization->address1,
                'address2'=>$organization->address2,
                'website'=>$organization->website,
                'type'=>$organization->type,
                'desc'=>$organization->desc,
                'fields'=>explode(", ",$organization->fields)
            ],
            'primary_contact'=>[
                'contact_name'=>$organization->contact_name,
                'contact_phone'=>$organization->contact_phone,
                'contact_title'=>$organization->contact_title,
                'contact_email'=>$organization->contact_email,
                'contact_address1'=>$organization->contact_address1,
                'contact_address2'=>$organization->contact_address2
            ],
            'secondary_contact'=>[
                'contact2_name'=>$organization->contact2_name,
                'contact2_phone'=>$organization->contact2_phone,
                'contact2_title'=>$organization->contact2_title,
                'contact2_email'=>$organization->contact2_email,
                'contact2_address1'=>$organization->contact2_address1,
                'contact2_address2'=>$organization->contact2_address2
            ]
        ];
    }
    private function modify_request($request){
        return [
            'key'=>$request->key,
            'org_code'=>$request->org_code,

            //Organization Information
            'name'=>$request->organization_information["name"],
            'address1'=>$request->organization_information["address1"],
            'address2'=>$request->organization_information["address2"],
            'website'=>$request->organization_information["website"],
            'type'=>$request->organization_information["type"],
            'desc'=>$request->organization_information["desc"],
            'fields'=>implode(", ",$request->organization_information["fields"]),

            //Primary Contact
            'contact_name'=>$request->primary_contact["contact_name"],
            'contact_phone'=>$request->primary_contact["contact_phone"],
            'contact_title'=>$request->primary_contact["contact_title"],
            'contact_email'=>$request->primary_contact["contact_email"],
            'contact_address1'=>$request->primary_contact["contact_address1"],
            'contact_address2'=>$request->primary_contact["contact_address2"],

            //Secondary Contact
            'contact2_name'=>$request->secondary_contact["contact2_name"],
            'contact2_phone'=>$request->secondary_contact["contact2_phone"],
            'contact2_title'=>$request->secondary_contact["contact2_title"],
            'contact2_email'=>$request->secondary_contact["contact2_email"],
            'contact2_address1'=>$request->secondary_contact["contact2_address1"],
            'contact2_address2'=>$request->secondary_contact["contact2_address2"]
        ];
    }

    public static function modify_register_request($request){
        return [
            'passcode'=>sha1($request->passcode),
            //Organization Information
            'name'=>$request->organization_information["name"],
            'address1'=>$request->organization_information["address1"],
            'address2'=>$request->organization_information["address2"],
            'website'=>$request->organization_information["website"],
            'type'=>$request->organization_information["type"],
            'desc'=>$request->organization_information["desc"],
            'fields'=>implode(", ",$request->organization_information["fields"]),

            //Primary Contact
            'contact_name'=>$request->primary_contact["contact_name"],
            'contact_phone'=>$request->primary_contact["contact_phone"],
            'contact_title'=>$request->primary_contact["contact_title"],
            'contact_email'=>$request->primary_contact["contact_email"],
            'contact_address1'=>$request->primary_contact["contact_address1"],
            'contact_address2'=>$request->primary_contact["contact_address2"],

            //Secondary Contact
            'contact2_name'=>$request->secondary_contact["contact2_name"],
            'contact2_phone'=>$request->secondary_contact["contact2_phone"],
            'contact2_title'=>$request->secondary_contact["contact2_title"],
            'contact2_email'=>$request->secondary_contact["contact2_email"],
            'contact2_address1'=>$request->secondary_contact["contact2_address1"],
            'contact2_address2'=>$request->secondary_contact["contact2_address2"]
        ];
    }
}
