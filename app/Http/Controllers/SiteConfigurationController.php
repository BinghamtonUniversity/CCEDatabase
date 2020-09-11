<?php

namespace App\Http\Controllers;

use App\SiteConfiguration;
use Illuminate\Http\Request;

class SiteConfigurationController extends Controller
{
    public function get_configurations(){
//        return $request;
        return SiteConfiguration::all();
    }
    public function edit_configuration(Request $request, SiteConfiguration $siteConfiguration){
//        return $siteConfiguration;
        $siteConfiguration->update(['value'=>$request->value]);
        return $siteConfiguration;
    }
}
