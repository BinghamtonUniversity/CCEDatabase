<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfiguration extends Model
{
    protected $primaryKey = 'id';
    protected $table = "configuration";
    public $timestamps = false;
//    protected $hidden = ['id','key'];
//    protected $casts = ['value' => 'object'];
    protected $fillable = ['key','value'];
}
