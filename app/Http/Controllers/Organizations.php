<?php

namespace App\Http\Controllers;

use App\Mail\OrganizationApproved;
use App\Conversation;
use Illuminate\Http\Request;
use App\Organization;
use App\Listing;
use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class Organizations extends Controller
{


    public function list_all(Request $request) {
        if(isset($request->shown)){
            $organizations = Organization::where('shown',($request->shown==='true')?true:false)->where('listed',true)->orderBy('key','asc')->get();
        }else {
            $organizations = Organization::orderBy('key','asc')->get();
        }
        $organizations_arr = [];
        foreach($organizations as $organization) {
            $organizations_arr[] = $organization->get_form_data();
        }
        return $organizations_arr;
    }

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
    public function password_fields(){
        return Organization::get_password_fields();
    }
    public function get_register_fields(){
        return Organization::get_register_organization_fields();
    }

    public static function add(Request $request){
        $organization = new Organization();
        $organization->save();
        $organization->org_code = $organization->key;
        $organization->passcode = sha1($request->passcode);
        $organization->update_from_form($request->all());

        $organization->email_sender('org_created');

        return $organization;
    }


    public function get(Request $request, Organization $organization) {
        return $organization->get_form_data();
    }

    public function update(Request $request, Organization $organization) {
        $organization->shown = false;
        $organization->update_from_form($request->all());

        if($organization->listed) {
            $organization->email_sender('org_updated');
        }
        return $organization->get_form_data();
    }

    public function admin_add(Request $request){
        $organization = new Organization();
        $organization->save();
        $organization->org_code = $organization->key;
        $organization->passcode = sha1($request->passcode);
        $organization->update_from_form($request->all());

        return $organization->get_form_data();
    }

    public function admin_update(Request $request, Organization $organization){
        $organization->update_from_form($request->all());

        return $organization->get_form_data();
    }


    public function admin_approve(Request $request, Organization $organization){
        if($organization->approve_org()){
            $organization->email_sender('org_approved');
            return $organization->get_form_data();
        }
    }

    public function delete(Request $request, Organization $organization){
        Listing::where('org_code',$organization->org_code)->delete();
        if($organization->delete()){
            return "Successfully Deleted!";
        } else{
            return "Failed to delete!";
        }
    }

    public function password_update(Request $request,Organization $organization){
        if ($organization->update(['passcode'=>sha1($request->passcode)])) {
            $organization->email_sender('password_update');

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

    public function password_request(Organization $organization){
        $encryption_obj = [
            'key'=>$organization->key,
            'timestamp'=>now()->timestamp
        ];
        if(isset($organization->contact2_email)){
            Mail::to(["email"=>$organization->contact2_email])->send(new EmailNotification(
                [
                    'reset_link'=>url('/manage/'.Crypt::encrypt(json_encode($encryption_obj))),
                    'org_name'=>$organization->name,
                    'name'=>$organization->contact2_name,
                    'manage_url'=>url('/manage/')
                ],'password_reset'));
        }
        Mail::to(["email"=>$organization->contact_email])->send(new EmailNotification(
            [
                'reset_link'=>url('/manage/'.Crypt::encrypt(json_encode($encryption_obj))),
                'org_name'=>$organization->name,
                'name'=>$organization->contact_name,
                'manage_url'=>url('/manage/')
            ],'password_reset'));
    }
    public function impersonate_user(Organization $organization){
        $encryption_obj = [
            'key'=>$organization->key,
            'timestamp'=>now()->timestamp
        ];
        return url('/manage/'.Crypt::encrypt(json_encode($encryption_obj)));
    }



    //Downloading all contacts in organizations and listings
    public function download_contacts(Request $request){
        $listings = DB::table('listings')
            ->leftjoin('orgs','orgs.org_code','=','listings.org_code')
            ->select('orgs.name as org_name','orgs.org_code','listings.title','listings.contact_name','listings.contact_title','listings.contact_email','listings.contact_phone','listings.contact_address1','listings.contact_address2',
                'listings.contact2_name','listings.contact2_title','listings.contact2_email','listings.contact2_phone','listings.contact2_address1','listings.contact2_address2','listings.timestamp')
            ->whereNotNull('orgs.org_code')
            ->whereNull('listings.deleted_at')
            ->whereNull('orgs.deleted_at')
            ->get();
        $organizations = Organization::get(['name','org_code','contact_name','contact_title','contact_email','contact_phone','contact_address1','contact_address2','contact2_name','contact2_title','contact2_email','contact2_phone','contact2_address1','contact2_address2','timestamp']);

//        return $listings;
        $new_listings = [];
        foreach ($listings as $listing){
            $new_listings[]=[
                'org_name'=>$listing->org_name,
//                'org_code'=>$listings->org_code,
                'listing_title'=>$listing->title,
                'contact_name'=>$listing->contact_name,
                'contact_title'=>$listing->contact_title,
                'contact_email'=>$listing->contact_email,
                'contact_phone'=>$listing->contact_phone,
                'contact_address1'=>$listing->contact_address1,
                'contact_address2'=>$listing->contact_address2,
                'updated_at'=>$listing->timestamp
            ];
            if($listing->contact2_name!=="") {
                $new_listings[] = [
                    'org_name' => $listing->org_name,
//                    'org_code'=>$listings->org_code,
                    'listing_title' => $listing->title,
                    'contact_name' => $listing->contact2_name,
                    'contact_title' => $listing->contact2_title,
                    'contact_email' => $listing->contact2_email,
                    'contact_phone' => $listing->contact2_phone,
                    'contact_address1' => $listing->contact2_address1,
                    'contact_address2' => $listing->contact2_address2,
                    'updated_at'=>$listing->timestamp
                ];
            }
        }

//        return sizeof($new_listings);
        $modified_organizations = [];
        foreach ($organizations as $organization){
            $modified_organizations[]=[
                'org_name'=>$organization->name,
                'listing_title' => 'N/A',
                'contact_name'=>$organization->contact_name,
                'contact_title'=>$organization->contact_title,
                'contact_email'=>$organization->contact_email,
                'contact_phone'=>$organization->contact_phone,
                'contact_address1'=>$organization->contact_address1,
                'contact_address2'=>$organization->contact_address2,
                'updated_at'=>$organization->timestamp
            ];
            if($organization->contact2_name!==""){
                $modified_organizations[]=[
                    'org_name'=>$organization->name,
                    'listing_title' => 'N/A',
                    'contact_name'=>$organization->contact2_name,
                    'contact_title'=>$organization->contact2_title,
                    'contact_email'=>$organization->contact2_email,
                    'contact_phone'=>$organization->contact2_phone,
                    'contact_address1'=>$organization->contact2_address1,
                    'contact_address2'=>$organization->contact2_address2,
                    'updated_at'=>$organization->timestamp
                ];
            }
        }

        $result = array_merge($new_listings,$modified_organizations);
        usort($result,function($a,$b){return strcmp($a['org_name'],$b['org_name']);});


        //Preparing for download
        $rows = [];
        if(count($result)>0){
            header('Content-type: text/csv');
            $rows[0] = '"'.implode('","',array_keys($result[0])).'"';
            foreach($result as $data){
                $rows[] = '"'.implode('","',array_values($data)).'"';
            }
            echo implode("\n",$rows);
        }
        else{
            return [];
        }

    }

    public function download_orgs(){
        $organizations = Organization::orderBy('key','desc')->get();
        $result = $organizations->toArray();

        //Preparing for download
        $rows = [];
        if(count($result)>0){
            header('Content-type: text/csv');
            $rows[0] = '"'.implode('","',array_keys($result[0])).'"';
            foreach($result as $data){
                $rows[] = '"'.implode('","',quote_replacer($data)).'"';
            }
            echo implode("\n",$rows);
        }
        else{
            return [];
        }

    }

}
