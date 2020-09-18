<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Mail\EmailNotification;
use App\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Listing;
use Illuminate\Support\Facades\Mail;

class Listings extends Controller
{



    public function list_all(Request $request){
        if(isset($request->shown)){
            $listings =  Listing::with(['organization'=>function($q){
                $q->select('org_code','name');
            }])->where('shown',($request->shown==='true')?true:false)->where('listed',true)->orderBy('creation_date','asc')->get();
        }
        else{
            $listings = Listing::with(['organization'=>function($q){
                $q->select('org_code','name');
            }])->orderBy('creation_date','desc')->get();
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

        $listing->email_sender('listing_created');

        return $listing->get_form_data();
    }

    public function admin_add(Request $request, Organization $organization){
        $listing = new Listing();
        $listing->creation_date = Carbon::now();
        $listing->org_code = $organization->org_code;
        $listing->shown = false;
        $listing->update_from_form($request->all());

        return $listing->get_form_data();
    }
    public function update(Request $request, Listing $listing) {
//        return $request;
        $listing->org_code = $request->org_code;
        $listing->shown = false;
        $listing->update_from_form($request->all());

        if($listing->listed)
        {
            $listing->email_sender('listing_updated');
        }
        return $listing->get_form_data();
    }
    public function admin_update(Request $request,Listing $listing){
        $listing->org_code = $request->org_code;
        $listing->update_from_form($request->all());

//        $listing->email_sender('listing_updated');
        return $listing->get_form_data();
    }
    public function admin_approve(Request $request, Listing $listing){
        if($listing->listing_approve()){
            $listing->email_sender('listing_approved');
            return "Listing ".$listing->title." approved!";
        }
        else{
            return "Cannot approved";
        }

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

    public function listings_download(){
        $listings = Listing::with(['organization'=>function($q){
            $q->select('org_code','name');
        }])->withTrashed()->orderBy('title','asc')->get();
        $result = [];
        foreach ($listings as $listing){
            $result[]=[
                'org_name'=>$listing->organization['name'],
                'title'=>$listing->title,
                'type'=>$listing->type,
                'category'=>$listing->category,
                'desc'=>$listing->desc,
                'fields'=>$listing->fields,
                'participants'=>$listing->participants,
                'related'=>$listing->related,
                'start_date'=>$listing->start_date,
                'end_date'=>$listing->end_date,
                'location'=>$listing->location,
                'location2'=>$listing->location2,
                'hours'=>$listing->hours,
                'time'=>$listing->time,
                'paid'=>parse_yesno($listing->paid),
                'bus_route'=>$listing->bus_route,
                'num_participants'=>$listing->num_participants,
                'days'=>$listing->days,
                'event_type'=>$listing->event_type,
                'req_training'=>parse_yesno($listing->req_training),
                'req_immune'=>parse_yesno($listing->req_immune),
                'req_application'=>parse_yesno($listing->req_application),
                'contact_name'=>$listing->contact_name,
                'contact_title'=>$listing->contact_title,
                'contact_email'=>$listing->contact_email,
                'contact_phone'=>$listing->contact_phone,
                'contact_address1'=>$listing->contact_address1,
                'contact_address2'=>$listing->contact_address2,
                'contact2_name'=>$listing->contact2_name,
                'contact2_title'=>$listing->contact2_title,
                'contact2_email'=>$listing->contact2_email,
                'contact2_phone'=>$listing->contact2_phone,
                'contact2_address1'=>$listing->contact2_address1,
                'contact2_address2'=>$listing->contact2_address2,
                'website'=>$listing->website,
                'shown'=>$listing->shown==true?"Shown":"Not Shown",
                'listed'=>$listing->listed==true?"Listed":"Not Listed",
                'updated_at'=>$listing->timestamp
            ];
        }

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

}
