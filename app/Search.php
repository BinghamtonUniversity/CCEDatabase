<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $primaryKey = 'key';
    protected $table = "searches";
    protected $fillable = ['keywords','event_type','category'];
    public $timestamps = false;
}
