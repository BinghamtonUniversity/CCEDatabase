<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $primaryKey = 'conversation_id';
    protected $table = "conversation_new";
//    protected $hidden = ['passcode','remember_token'];
//    public $timestamps = false;
    protected $fillable = [
        'conversation_id','student_first_name','student_last_name','student_email','student_phone_number',
        'message','listing_key','org_code'
    ];
    public function listing(){
        return $this->belongsTo(Listing::class,'listing_key','key');
    }
    public function org(){
        return $this->belongsTo(Organization::class,'org_code','org_code');
    }
//    public function email_sender(Organization $organization,Listing $listing=null){
//        if(isset($listing)){
//            $email_content = [
//                'name' => $listing->contact_name,
//                'student_name' => $this->student_first_name . ' ' . $this->student_last_name,
//                'message' => $this->message,
//                'org_name' => $organization->name,
//                'listing_name'=>$listing->title,
//                'replyTo' => $this->student_email
//            ];
//        }
//        else{
//            $email_content = [
//                'name' => $organization->contact2_name,
//                'student_name' => $this->student_first_name.' '. $this->student_last_name,
//                'message' => $this->message,
//                'org_name' => $organization->name,
//                'replyTo' => $this->student_email
//            ];
//        }
//        if(isset($email_content['listing_name'])){
//
//        }
//    }
}
