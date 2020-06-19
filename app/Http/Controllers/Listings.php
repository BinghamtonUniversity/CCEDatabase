<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;

class Listings extends Controller
{
    public function fetch_list(Request $request) {
        $listings = Listing::select('title','key')->orderBy('title')->get();
        $listings_arr = [];
        foreach($listings as $listing) {
            $listings_arr[] = [
                'label' => $listing->title,
                'value' => $listing->key,
            ];
        }
        return $listings_arr;
    }
    public function get(Request $request, Listing $listing) {
        return $listing;
    }

    public function update(Request $request, Listing $listing) {
        $listing->update($request->all());
        $listing->shown = false;
        return $listing;
    }

}
