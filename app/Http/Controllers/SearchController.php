<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;
use App\Listing;
use App\Organization;
use \Carbon\Carbon;
use mysql_xdevapi\TableSelect;
use Symfony\Component\Console\Helper\Table;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    private function add_search($request){
        $search = new Search(['keywords'=>$request]);
        $search->save();
    }

    private function sort_data($search_results, $fields) {
        foreach($search_results as $key => $row) {
            foreach($fields as $field) {
                if (stristr($row->fields,$field)) {
                    $search_results[$key]->rank++;
                    $search_results[$key]->found.=$field.', ';
                }
            }
        }
        // dd($search_results);
        $search_results = $search_results->toArray();
        usort($search_results, function ($item1, $item2) {
            if ($item1->rank == $item2->rank) { return 0; }
            return $item1->rank > $item2->rank ? -1 : 1;
        });
        return $search_results;
    }
    private function search_listings($category, $fields,$event_type) {
        // "select `key`, `title`, `fields`, `desc` from listings where ".
        // "(ongoing > 0 or (now() <= end_date))".
        // "and category like '%".$_GET['category']."%' and (".get_fields_subquery().")";
        $listings = Listing::select('key','title','fields','desc')
            ->where('category','like','%'.$category.'%')
            ->where('event_type','=',$event_type)
//            ->orWhere(function($query) {
//                $query->where('event_type','=','ongoing');
//                $query->orWhere('end_date','>',Carbon::now());
//            })
            ->where(function($query) use ($fields) {
                foreach($fields as $field){
                    $query->orWhere('fields','like','%'.$field.'%');
                }
            })->get();
        // $listings = $this->sort_data($listings,$fields);
        return $listings;
    }
    private function search_organizations($fields) {
        // "select `org_code`, `name`, `fields`, `desc` from orgs where (".get_fields_subquery().")";
        $orgs = Organization::select('key','org_code','name','fields','desc')
            ->where(function($query) use ($fields) {
                foreach($fields as $field){
                    $query->orWhere('fields','like','%'.$field.'%');
                }
            })->get();
        // $orgs = $this->sort_data($orgs,$fields);
        return $orgs;
    }
    public function advanced_search(Request $request) {
//        var_dump($request);

        $category = ''; $fields = [];$event_type='';
        if ($request->has('category')){
            $category = $request->category;
        }
        if ($request->has('fields')){
            $fields = $request->fields;
        }
        if($request->has('event_type')){
            $event_type = $request->event_type;
        }
        return [
            'listings'=>$this->search_listings($category, $fields,$event_type),
            'organizations'=>$this->search_organizations($fields),
        ];
    }
    public function search_page(Request $request) {
        return view('search.search');
    }
    public function search_results_page(Request $request) {

        $results = $this->advanced_search($request);
        return view('search.search_results',$results);
    }
    public function google_search_results_page(Request $request) {
        $q='';

        if ($request->has('q')){
            $q = $request->q;
        }

        return view('search.google_search_results',[
            'q'=>$q
        ]);
    }
    public function google_search_results_iframe(Request $request) {
        $q='';
        header('X-Robots-Tag: noindex');
        if ($request->has('q')){
            $q = $request->q;
        }
        $this->add_search($q);

        $data = file_get_contents('https://cse.google.com/cse?cx=017783623567823574052:gjraiskf2ly&ad=n9&num=10&cof=FORID:11&ie=UTF-8&q='.urlencode($q));
        $data2 = str_replace("/cse.js","https://cse.google.com/cse.js",$data);
        return $data2;
    }
    public function get_all_searches(){
        $year = Carbon::now()->format('Y');
        if((int)Carbon::now()->format('m')<8){
            $year = $year-1;
        }
        $date_string = strtotime('08/01/'.$year);

        return
            DB::table('searches')
            ->orderBy('key','asc')
            ->whereDate('timestamp', '>=',date('Y-m-d',$date_string) )->get();
    }


}
