<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\Organization;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrgAdmin extends Controller
{
    public function login(Request $request) {
        return view('orgadmin.login');
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
                'organization_fields'=>Organization::get_fields(),
                'listing_fields'=>Listing::get_fields()
            ]);
        } else {
            return redirect(url('/manage/login'));
        }
    }

}
