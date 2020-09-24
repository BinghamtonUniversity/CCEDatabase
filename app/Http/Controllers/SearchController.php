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
    private function add_search($keywords,$category=null,$event_type=null){
        $search = new Search(['keywords'=>$keywords,'category'=>$category,'event_type'=>$event_type]);
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
        $search_results = $search_results->toArray();
        usort($search_results, function ($item1, $item2) {
            if ($item1->rank == $item2->rank) { return 0; }
            return $item1->rank > $item2->rank ? -1 : 1;
        });
        return $search_results;
    }
    private function search_listings($category, $fields,$event_type) {
        $listings = Listing::select('key','title','fields','desc')
            ->where(function($query) use ($fields) {
                foreach($fields as $field){
                    $query->orWhere('fields','like','%'.$field.'%');
                }
            })->where('listed',true)->where('shown',true);
        if($category!==""){
            $listings->where('category','like','%'.$category.'%');
        }
        if($event_type!=="" ){
            $listings->where('event_type','=',$event_type);
        }
        return $listings->get();
    }
    private function search_organizations($fields) {
        $orgs = Organization::select('key','org_code','name','fields','desc')
            ->where(function($query) use ($fields) {
                foreach($fields as $field){
                    $query->orWhere('fields','like','%'.$field.'%');
                }
            })->where('listed',true)->where('shown',true)->get();
        return $orgs;
    }
    public function advanced_search(Request $request) {
        $category = ''; $fields = [];$event_type='';
        if ($request->has('category')&& !check_empty($request->category)){
            $category = $request->category;
        }
        if ($request->has('fields')){
            $fields = $request->fields;
        }
        if($request->has('event_type') && !check_empty($request->event_type)){
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
        $this->add_search(implode(',',$request->fields),$request->category,$request->event_type);
        $results = $this->advanced_search($request);
        return view('search.search_results',$results);
    }
    public function google_search_results_page(Request $request) {
        $q='';

        if ($request->has('q')){
            $q = $request->q;
        }
//        return
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
        return Search::whereBetween('timestamp',[Carbon::now()->addYears(-1),Carbon::now()])
            ->orderBy('key','asc')
            ->get();
    }

    public function download_searches(){
        $searches = Search::orderBy('timestamp','desc')->get();
        $result = $searches->toArray();

        //Preparing for download
        $rows = [];
        if(count($result)>0){
            header('Content-type: text/csv');
            $rows[0] = '"'.implode('","',array_keys($result[0])).'"';
            foreach($result as $data){
                $rows[] = '"'.implode('","',quote_replacer($data)).'"';
            }
            echo implode("\n",$rows);
        }
        else{
            return [];
        }

    }


}
