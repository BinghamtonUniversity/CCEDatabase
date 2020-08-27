<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\Organization;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OrgAdmin extends Controller
{
    public function login(Request $request) {
        return view('orgadmin.login',['register_organization'=>Organization::get_register_organization_fields()]);
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect(url('/manage/login'));
    }
    public function authenticate(Request $request) {
        $organization = Organization::where('key',$request->organization)
            ->where('passcode',sha1($request->password))->first();
        if (!is_null($organization)) {
            Auth::login($organization,true);
            return Auth::user();
        } else {
            return response('Unauthorized.', 401);
        }
    }
    public function manage(Request $request) {
        if (Auth::check()) {
            return view('orgadmin.manage',[
                'organization_password_change'=>Organization::get_password_fields(),
                'organization_fields'=>Organization::get_fields(),
                'listing_fields'=>Listing::get_fields()
            ]);
        } else {
            return redirect(url('/manage/login'));
        }
    }
    public function register(Request $request){
        $organization = Organizations::add($request);

//        $organization = Organization::where('key',$new_organization['key'])
//            ->where('passcode',sha1($request->passcode))->first();

        if(!is_null($organization)) {
            Auth::login($organization,true);
            return view('orgadmin.manage',[
                'organization_password_change'=>Organization::get_password_fields(),
                'organization_fields'=>Organization::get_fields(),
                'listing_fields'=>Listing::get_fields()
            ]);
        } else {
            return "Failed";
        }
    }

    public function password_reset(Request $request,$pass){
        $result = json_decode(Crypt::decrypt($pass));

        if((now()->timestamp - $result->timestamp)/60 <= 10){
            $organization = Organization::where('key',$result->key)->first();
            if (!is_null($organization)) {
                Auth::login($organization, true);
                return view('orgadmin.manage', [
                    'organization_password_change' => Organization::get_password_fields(),
                    'organization_fields' => Organization::get_fields(),
                    'listing_fields' => Listing::get_fields()
                ]);
            } else {
                return "Link Expired!";
            }
        }
        else{
            return "Failed";
        }

    }



}
