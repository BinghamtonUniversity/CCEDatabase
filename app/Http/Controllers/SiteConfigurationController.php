<?php

namespace App\Http\Controllers;

use App\SiteConfiguration;
use Illuminate\Http\Request;

class SiteConfigurationController extends Controller
{
    public function get_configurations(){
        return SiteConfiguration::orderBy('key')->get();
    }
    public function edit_configuration(Request $request, SiteConfiguration $siteConfiguration){
        $siteConfiguration->update(['value'=>$request->value]);
        return $siteConfiguration;
    }
}
