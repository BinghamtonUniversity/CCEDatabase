<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $primaryKey = 'key';
    protected $table = "listings";

    public function organization() {
        return $this->belongsTo(Organization::class,'org_code','org_code');
    }
  
}
