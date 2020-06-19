<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'key';
    protected $table = "orgs";

    public function listings() {
        return $this->hasMany(Listing::class);
    }
  
}
