<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Organization;
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
            })->where('listed',true)->where('shown',true)
            ->where(function($query) {
                $query->whereNull('end_date');
                $query->orWhere('end_date','>',Carbon::now());
                $query->orWhere('event_type','ongoing');
            });
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
    public function advanced_search_results_page(Request $request) {
        $this->add_search(implode(',',$request->fields),$request->category,$request->event_type);
        $results = $this->advanced_search($request);
        return response()
            ->view('search.search_results', $results)
            ->header('X-Robots-Tag', 'noindex');
    }

    public function simple_search($query) {
        $words = array_filter(explode(' ', $query)); 
        $orgsSearch = Organization::query();
        
        $orgScoreSql = "0";
        foreach ($words as $word) {
            $escaped = '%' . $word . '%';
            $orgScoreSql .= " + (CASE WHEN name LIKE '{$escaped}' THEN 10 ELSE 0 END)";
            $orgScoreSql .= " + (CASE WHEN `desc` LIKE '{$escaped}' THEN 2 ELSE 0 END)";
        }

        $orgs = $orgsSearch->selectRaw("*, ({$orgScoreSql}) as relevance")
            ->where(function($q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('name', 'LIKE', "%{$word}%")
                    ->orWhere('desc', 'LIKE', "%{$word}%");
                }
            })
            ->where('listed',true)->where('shown',true)
            ->having('relevance', '>', 0)
            ->orderByDesc('relevance')
            ->limit(20)
            ->get();

        $listingsSearch = Listing::query();

        $listingScoreSql = "0";
        foreach ($words as $word) {
            $escaped = '%' . $word . '%';
            $listingScoreSql .= " + (CASE WHEN title LIKE '{$escaped}' THEN 10 ELSE 0 END)";
            $listingScoreSql .= " + (CASE WHEN fields LIKE '{$escaped}' THEN 5 ELSE 0 END)";
            $listingScoreSql .= " + (CASE WHEN `desc` LIKE '{$escaped}' THEN 2 ELSE 0 END)";
        }

        $listings = $listingsSearch->selectRaw("*, ({$listingScoreSql}) as relevance")
            ->where(function($q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('title', 'LIKE', "%{$word}%")
                    ->orWhere('fields', 'LIKE', "%{$word}%")
                    ->orWhere('desc', 'LIKE', "%{$word}%");
                }
            })
            ->where('listed',true)->where('shown',true)
            ->where(function($query) {
                $query->whereNull('end_date');
                $query->orWhere('end_date','>',Carbon::now());
                $query->orWhere('event_type','ongoing');
            })
            ->having('relevance', '>', 0)
            ->orderByDesc('relevance')
            ->limit(20)
            ->get();

        return [
            'listings'=>$listings,
            'organizations'=>$orgs,
        ];
    }

    public function simple_search_results_page(Request $request) {
        $q='';
        if ($request->has('q')){
            $q = $request->q;
            $this->add_search($q);
        }
        return response()
            ->view('search.search_results', $this->simple_search($q))
            ->header('X-Robots-Tag', 'noindex');
    }

    public function search_page(Request $request) {
        return view('search.search');
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
