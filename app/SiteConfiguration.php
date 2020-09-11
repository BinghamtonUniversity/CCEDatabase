<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfiguration extends Model
{
    protected $primaryKey = 'id';
    protected $table = "configuration";
    public $timestamps = false;
    protected $fillable = ['key','value'];
}
