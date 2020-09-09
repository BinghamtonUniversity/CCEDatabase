<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Listing;
use App\Mail\EmailNotification;
use App\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function foo\func;

class Conversations extends Controller
{
    public function add(Request $request,$obj_arr)
    {
        $conversation = new Conversation($obj_arr);
        $conversation->save();

        return $conversation;
    }

    public function add_listing_conversation(Request $request, Listing $listing) {
        // Send an email to contact1 and contact2 for the listing
        // CC the person who submitted the form on the email
        // Set "reply to" to the person who submitted the form

        $conversation = $this->add($request,['student_first_name'=>$request->first_name, 'student_last_name'=>$request->last_name,
            'student_email'=>$request->email,'student_phone_number'=>$request->phone,
            'message'=>$request->message,'org_code'=>$listing->org_code,'listing_key'=>$listing->key]);

        $organization = Organization::where('org_code',$listing->org_code)->first();
        $email_content = [
            "student"=>[
                "first_name"=>$conversation->student_first_name,
                "last_name"=>$conversation->student_last_name
            ],
            "listing"=>[
                "name"=>$listing->title
            ],
            "organization"=>[
                "name"=>$organization->name
            ]
        ];

        Mail::to(['email'=>$conversation->student_email])
            ->send(new EmailNotification($email_content,'listing_contact'));

        if(isset($listing->contact2_email))
        {
            Mail::to(['email' => $listing->contact2_email])
                ->send(new EmailNotification([
                    'name' => $listing->contact2_name,
                    'student_name' => $conversation->student_first_name.' '. $conversation->student_last_name,
                    'student_email'=>$conversation->student_email,
                    'student_phone'=>$conversation->student_phone_number,
                    'student_message' => $conversation->message,
                    'org_name' => $organization->name,
                    'manage_listing_url'=>url('/manage'),
                    'listing_name'=>$listing->title,
                    'replyTo' => $conversation->student_email
                ], 'listing_user_message'));
        }
        Mail::to(['email' => $listing->contact_email])
            ->send(new EmailNotification([
                'name' => $listing->contact_name,
                'student_name' => $conversation->student_first_name.' '. $conversation->student_last_name,
                'student_email'=>$conversation->student_email,
                'student_phone'=>$conversation->student_phone_number,
                'student_message' => $conversation->message,
                'manage_listing_url'=>url('/manage'),
                'org_name' => $organization->name,
                'listing_name'=>$listing->title,
                'replyTo' => $conversation->student_email
            ], 'listing_user_message'));

        return $listing;
    }

    public function add_org_conversation(Request $request, Organization $organization) {
        // Send an email to contact1 and contact2 for the organization
        // CC the person who submitted the form on the email
        // Set "reply to" to the person who submitted the form
        $conversation = $this->add($request,['student_first_name'=>$request->first_name, 'student_last_name'=>$request->last_name,
            'student_email'=>$request->email,'student_phone_number'=>$request->phone,
            'message'=>$request->message,'org_code'=>$organization->org_code]);

        $email_content = [
            "student"=>[
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name
            ],
            "organization"=>[
                "name"=>$organization->name
            ]
        ];

        Mail::to(['email'=>$conversation->student_email])
            ->send(new EmailNotification($email_content,'org_contact'));

        if(isset($organization->contact2_email))
        {
            Mail::to(['email' => $organization->contact2_email])
                ->send(new EmailNotification([
                    'name' => $organization->contact2_name,
                    'student_name' => $conversation->student_first_name.' '. $conversation->student_last_name,
                    'student_email'=>$conversation->student_email,
                    'student_phone'=>$conversation->student_phone_number,
                    'student_message' => $conversation->message,
                    'org_name' => $organization->name,
                    'replyTo' => $conversation->student_email
                ], 'org_user_message'));
        }
        Mail::to(['email' => $organization->contact_email])
            ->send(new EmailNotification([
                'name' => $organization->contact_name,
                'student_name' => $conversation->student_first_name.' '. $conversation->student_last_name,
                'student_email'=>$conversation->student_email,
                'student_phone'=>$conversation->student_phone_number,
                'student_message' => $conversation->message,
                'org_name' => $organization->name,
                'replyTo' => $conversation->student_email
            ], 'org_user_message'));

        return $organization;
    }

    public function get_all_conversations(){
        return Conversation::with(['listing'=>function($q){
            $q->select('key','title','org_code');
        }])->with(['org'=>function($q){
            $q->select('key','org_code','name');
        }])->whereBetween('created_at',[Carbon::now()->addYears(-1),Carbon::now()])
            ->orderBy('created_at','asc')
            ->get();
    }
    public function get_conversation(Request $request,Conversation $conversation){
        return Conversation::where('conversation_id',$conversation->conversation_id)
            ->with(['listing'=>function($q){
            $q->select('key','title','org_code');
        }])->with(['org'=>function($q){
            $q->select('key','org_code','name');
        }])->first();
    }
}
