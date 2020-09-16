<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $primaryKey = 'conversation_id';
    protected $table = "conversation_new";
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
}
