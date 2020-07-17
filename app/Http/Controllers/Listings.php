<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;

class Listings extends Controller
{

    public function get(Request $request, Listing $listing) {
        return $listing;
    }
    public function add(Request $request){
        return $this->modify_request($request);
//        $listing = new Listing($this->modify_request($request));
//        $listing->shown = false;
//        $listing->save();
//        return $listing;
    }

    public function update(Request $request, Listing $listing) {
        $listing->update($this->modify_request($request));
        $listing->shown = false;
        return $listing;
    }
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

        static public function modify_output($listings){
        $modified_list = [];

        //To get the value in Involved People Field
        $involved_people_array = array_column(Listing::get_fields()[4]["fields"][0]["options"][0]["options"],"value");
        //To get the value in University Offices Field
        $offices_array = array_column(Listing::get_fields()[4]["fields"][2]["options"][0]["options"],"value");

        //Get hours defined in the form definition
        $hours_array = array_column(Listing::get_fields()[2]["fields"][13]["options"][0]["options"],"value");

        //Get the participants defined in the form definition
        $num_participants_array = array_column(Listing::get_fields()[2]["fields"][16]["options"][0]["options"],"value");


        foreach($listings as $list){
            $listing = [
                "key"=>$list->key,
                "org_code"=>$list->org_code,
//                "website"=>$list->website,
                "project_information"=>[
                    "type"=>$list->type,
                    "title"=>$list->title,
                    "location"=>$list->location,
                    "location2"=>$list->location2,
                    "category"=>explode(", ",$list->category),
                    "bus_route"=>$list->bus_route,
                    "ongoing"=>$list->ongoing===0?false:true,
                    "start_date"=>$list->ongoing===0?date('m-d-Y', strtotime($list->start_date)):null,
                    "end_date"=>$list->ongoing===0?date('m-d-Y', strtotime($list->end_date)):null,
                    "fields"=>explode(", ",$list->fields),
                    "paid"=>explode("<-|->",$list->paid)[0],
                    "paid_amount"=>explode("<-|->",$list->paid)[1],
                    "hours"=>$list->type==="short"?in_array($list->hours,$hours_array)?$list->hours:"Other":null,
                    "weekly_hours"=>$list->type==="long"?in_array($list->hours,$hours_array)?$list->hours:"Other":null,
                    "other_hour"=> in_array($list->hours,$hours_array)?null:$list->hours,
                    "num_participants"=>in_array($list->num_participants,$num_participants_array)?$list->num_participants:"Other",
                    "other_people"=>in_array($list->num_participants,$num_participants_array)?null:$list->num_participants,
                    "days"=>explode(", ",$list->days),
                    "desc"=>$list->desc,
                    "time"=>explode(", ",$list->time)
                ],
                "contact_info"=>[
                    "primary_contact"=>[
                        "contact_name"=>$list->contact_name,
                        "contact_title"=>$list->contact_title,
                        "contact_email"=>$list->contact_email,
                        "contact_phone"=>$list->contact_phone,
                        "contact_address1"=>$list->contact_address1,
                        "contact_address2"=>$list->contact_address2,
                    ],
                    "secondary_contact"=>[
                        "contact2_name"=>$list->contact2_name,
                        "contact2_title"=>$list->contact2_title,
                        "contact2_email"=>$list->contact2_email,
                        "contact2_phone"=>$list->contact2_phone,
                        "contact2_address1"=>$list->contact2_address1,
                        "contact2_address2"=>$list->contact2_address2
                    ]
                ],
//                "participant_information"=>[
//                    "involved_people_type"=>explode(", ",$list->participants),
//                    "university_offices"=>explode(", ",$list->related)
//                ],
                "project_requirements"=>[
                    "reqs_training"=>explode("<-|->",$list->reqs_training)[0],
                    "specify_training"=>explode("<-|->",$list->reqs_training)[0]==="YES"?explode("<-|->",$list->reqs_training)[1]:null,
                    "reqs_immune"=>explode("<-|->",$list->reqs_immune)[0],
                    "specify_immune"=>explode("<-|->",$list->reqs_immune)[0]==="YES"?explode("<-|->",$list->reqs_immune)[1]:null,
                    "reqs_application"=>explode("<-|->",$list->reqs_application)[0],
                    "specify_application"=>explode("<-|->",$list->reqs_application)[0]==="YES"?explode("<-|->",$list->reqs_application)[1]:null,
                    "reqs_desc"=>$list->reqs_desc
                ]
            ];


            //Looking for Other in Involved People
            $result_array = [];
            foreach (explode(", ",$list->participants) as $participant){
                if(in_array($participant,$involved_people_array)){
                    $result_array[]=$participant;
                }
                else{
                    $result_array[] = "Other";
                    $listing["participant_information"]["involve_other"] = $participant;
                }
            }
            $listing["participant_information"]["involved_people_type"] = $result_array;

            //Looking for Other in Related University Offices
            $result_array=[];
            foreach (explode(", ",$list->related) as $related_office){
                if(in_array($related_office,$offices_array)){
                    $result_array[]=$related_office;
                }
                else{
                    $result_array[] = "Other";
                    $listing["participant_information"]["other_university_office"] = $related_office;
                }
            }
            $listing["participant_information"]["university_offices"] = $result_array;


        $modified_list[]=$listing;
        }
        return $modified_list;
    }

    private function modify_request($list){

        return [
            "key"=>$list->key,
            "org_code"=>$list->org_code,
//            "website"=>$list->website,
            "type"=>$list->project_information["type"],
            "title"=>$list->project_information["title"],
            "location"=>$list->project_information["location"],
            "location2"=>$list->project_information["location2"],
            "category"=>implode(", ",$list->project_information["category"]),
            "bus_route"=>$list->project_information["bus_route"],
            "num_participants"=>$list->project_information["num_participants"]==="Other"?$list->project_information["other_people"]:$list->project_information["num_participants"],
            "ongoing"=>$list->project_information["ongoing"]==1,
            "start_date"=>isset($list->project_information["start_date"])?(date('Y-m-d',strtotime($list->project_information["start_date"]))):null,
            "end_date"=>isset($list->project_information["end_date"])?(date('Y-m-d',strtotime($list->project_information["end_date"]))):null,
            "fields"=>implode(", ",$list->project_information["fields"]),
            "paid"=>($list->project_information["paid"]==="YES")?$list->project_information["paid"]."<-|->".$list->project_information["paid_amount"]:$list->project_information["paid"]."<-|->",
            "hours"=>$list->project_information["type"]==="short"?$list->project_information["hours"]==="Other"?$list->project_information["other_hour"]:$list->project_information["hours"]:$list->project_information["weekly_hours"]==="Other"?$list->project_information["other_hour"]:$list->project_information["weekly_hours"],
            "days"=>implode(", ",$list->project_information["days"]),
            "desc"=>$list->project_information["desc"],
            "time"=>implode(", ",$list->project_information["time"]),

            "contact_name"=>$list->contact_info["primary_contact"]["contact_name"],
            "contact_title"=>$list->contact_info["primary_contact"]["contact_title"],
            "contact_email"=>$list->contact_info["primary_contact"]["contact_email"],
            "contact_phone"=>$list->contact_info["primary_contact"]["contact_phone"],
            "contact_address1"=>$list->contact_info["primary_contact"]["contact_address1"],
            "contact_address2"=>$list->contact_info["primary_contact"]["contact_address2"],

            "contact2_name"=>$list->contact_info["secondary_contact"]["contact2_name"],
            "contact2_title"=>$list->contact_info["secondary_contact"]["contact2_title"],
            "contact2_email"=>$list->contact_info["secondary_contact"]["contact2_email"],
            "contact2_phone"=>$list->contact_info["secondary_contact"]["contact2_phone"],
            "contact2_address1"=>$list->contact_info["secondary_contact"]["contact2_address1"],
            "contact2_address2"=>$list->contact_info["secondary_contact"]["contact2_address2"],

            "participants"=>in_array("Other",$list->participant_information["involved_people_type"])?implode(", ",$list->participant_information["involved_people_type"]).", ".$list->participant_information["involve_other"]:implode(", ",$list->participant_information["involved_people_type"]),
            "related"=>in_array("Other",$list->participant_information["university_offices"])?implode(", ",$list->participant_information["university_offices"]).", ".$list->participant_information["other_university_office"]:implode(", ",$list->participant_information["university_offices"]),

            "reqs_training"=>($list->project_requirements["reqs_training"]==="YES")?$list->project_requirements["reqs_training"]."<-|->".$list->project_requirements["specify_training"]:$list->project_requirements["reqs_training"]."<-|->",
            "reqs_immune"=>($list->project_requirements["reqs_immune"]==="YES")?$list->project_requirements["reqs_immune"]."<-|->".$list->project_requirements["specify_immune"]:$list->project_requirements["reqs_immune"]."<-|->",
            "reqs_application"=>($list->project_requirements["reqs_application"]==="YES")?$list->project_requirements["reqs_application"]."<-|->".$list->project_requirements["specify_application"]:$list->project_requirements["reqs_application"]."<-|->",
            "reqs_desc"=>$list->project_requirements["reqs_desc"]
        ];
    }

}
