<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $primaryKey = 'key';
    protected $table = "listings";
    public $timestamps = false;
    protected $casts = [
        'creation_date'=>'date:Y-m-d'
    ];
    protected $fillable = [
        'key','org_code','name','location','location2','type','title','category',
        'bus_route', 'num_participants','ongoing','start_date','end_date',
        'fields','paid','hours','days','desc','time',
        'contact_name','contact_title','contact_email','contact_phone',
        'contact_address1','contact_address2','contact2_name','contact2_title',
        'contact2_email', 'contact2_phone','contact2_address1','contact2_address2',
        'participants','related','reqs_training','reqs_immune','reqs_application','reqs_desc','visible','creation_date'
    ];

    public function organization() {
        return $this->belongsTo(Organization::class,'org_code','org_code');
    }

    public function updateListing($listing,$org_code){
        $this->update(self::modifyListing($listing,$org_code));
        $this->visible = false;
        return $this;
    }
//    public function addListing($request)

    public static function modifyListing($list,$org_code){
//        $this->attributes["key"] = $list->key;
        $listing = [
            "key"=>$list->key,
            "org_code"=>$org_code,
            "website"=>$list->website,
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

            "reqs_training"=>($list->project_requirements["reqs_training"]==="YES")?$list->project_requirements["reqs_training"]."<-|->".$list->project_requirements["specify_training"]:$list->project_requirements["reqs_training"]."<-|->",
            "reqs_immune"=>($list->project_requirements["reqs_immune"]==="YES")?$list->project_requirements["reqs_immune"]."<-|->".$list->project_requirements["specify_immune"]:$list->project_requirements["reqs_immune"]."<-|->",
            "reqs_application"=>($list->project_requirements["reqs_application"]==="YES")?$list->project_requirements["reqs_application"]."<-|->".$list->project_requirements["specify_application"]:$list->project_requirements["reqs_application"]."<-|->",
            "reqs_desc"=>$list->project_requirements["reqs_desc"]
        ];

        //Other Hours Handling
        if($list->project_information["type"]==="short"){
            if($list->project_information["hours"]==="Other"){
                $listing["hours"]=$list->project_information["other_hour"];
            }
            else{
                $listing["hours"]=$list->project_information["hours"];
            }
        }
        if($list->project_information["type"]==="long"){
            if($list->project_information["weekly_hours"]==="Other"){
                $listing["hours"]=$list->project_information["other_hour"];
            }
            else{
                $listing["hours"]=$list->project_information["weekly_hours"];
            }
        }

        //Other Participants Handling
        $temp_array = [];
        foreach($list->participant_information["involved_people_type"] as $participant){
            if($participant === "Other"){
                $temp_array[]=$list->participant_information["involve_other"];
            }
            else{
                $temp_array[]=$participant;
            }
        }
        $listing["participants"]=implode(", ",$temp_array);

        //Other University Offices Handling
        $temp_array = [];
        foreach($list->participant_information["university_offices"] as $office){
            if($office === "Other"){
                $temp_array[]=$list->participant_information["other_university_office"];
            }
            else{
                $temp_array[]=$office;
            }
        }
        $listing["related"]=implode(", ",$temp_array);

        return $listing;
    }


    public function getListing($list){
        //To get the value in Involved People Field
        $involved_people_array = array_column(self::get_fields()[4]["fields"][0]["options"][0]["options"],"value");
        //To get the value in University Offices Field
        $offices_array = array_column(self::get_fields()[4]["fields"][2]["options"][0]["options"],"value");

        //Get hours defined in the form definition
        $hours_array = array_column(self::get_fields()[2]["fields"][13]["options"][0]["options"],"value");

        //Get the participants defined in the form definition
        $num_participants_array = array_column(self::get_fields()[2]["fields"][16]["options"][0]["options"],"value");

        $listing = [
            "key"=>$list->key,
            "org_code"=>$list->org_code,
            "website"=>$list->website,
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

        return $listing;
    }
    static public function get_fields() {
        $fields = [
            [
                "name"=> "key",
                "type"=> "hidden"
            ],
            [
                "name"=> "org_code",
                "type"=> "hidden"
            ],
            [
                "type"=> "fieldset",
                "label"=> "Project Information",
                "name"=> "project_information",
//                "template"=>"{{project_information.title}}",
                "fields"=> [

                    [
                        "type"=> "select",
                        "label"=> "Project Type",
                        "name"=> "type",
                        "multiple"=> false,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Short Term (Lasting Less that a Week)",
                                        "value"=> "short"
                                    ],
                                    [
                                        "label"=> "Long Term (Lasting More than a Week, or periodically over a long period)",
                                        "value"=> "long"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Title of Project Listing",
                        "name"=> "title",
                        "required"=> true,
                        "type"=> "text"
                    ],
                    [
                        "label"=> "Location of Project (Valid Address)",
                        "name"=> "location",
                        "required"=> true,
                        "type"=> "text"
                    ],
                    [
                        "label"=> "Location of Project (Continued)",
                        "name"=> "location2",
                        "required"=> true,
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Category",
                        "name"=> "category",
                        "help"=> "Hold CTRL or command to select multiple.",
                        "multiple"=> true,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Internship",
                                        "value"=> "Internship"
                                    ],
                                    [
                                        "label"=> "Research",
                                        "value"=> "Research"
                                    ],
                                    [
                                        "label"=> "Service",
                                        "value"=> "Service"
                                    ],
                                    [
                                        "label"=> "Group Project",
                                        "value"=> "Group Project"
                                    ],
                                    [
                                        "label"=> "Academic Service Learning Class",
                                        "value"=> "Academic Service Learning Class"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "name"=> "ongoing",
                        "type"=> "checkbox",
                        "label"=> "Ongoing",
                        "options"=> [
                            [
                                "label"=> "No",
                                "value"=> 0
                            ],
                            [
                                "label"=> "Yes",
                                "value"=> 1
                            ],
                        ]
                    ],
                    [
                        "type"=> "date",
                        "label"=> "Project Start Date",
                        "name"=> "start_date",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "ongoing",
                                        "value"=> 0
                                    ]
                                ]
                            ]
                        ],
                        "format"=> [
                                    "input"=> "MM/DD/YYYY"
                                ],
                        "required"=> true
                    ],
                    [
                        "type"=> "date",
                        "label"=> "Project End Date",
                        "name"=> "end_date",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "ongoing",
                                        "value"=> 0
                                    ]
                                ]
                            ]
                        ],
                        "format"=> [
                            "input"=> "MM/DD/YYYY"
                        ],
                        "required"=> true
                    ],
                    [
                        "type"=> "radio",
                        "label"=> "Project Field(s) of Work (Check all that apply)",
                        "name"=> "fields",
                        "help"=> "Hold CTRL or command to select multiple.",
                        "multiple"=> true,
                        "options"=> config('app.categories'),
                        "required"=>true
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "other_field",
                        "show"=> false,
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Paid?",
                        "name"=> "paid",
                        "multiple"=> false,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "YES",
                                        "value"=> "YES"
                                    ],
                                    [
                                        "label"=> "NO",
                                        "value"=> "NO"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Paid Amount",
                        "name"=> "paid_amount",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "paid",
                                        "value"=> [
                                            "YES"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> true,
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Total Estimated Hours",
                        "name"=> "hours",
                        "multiple"=> false,
                        "forceRow"=> true,
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "type",
                                        "value"=> [
                                            "short"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "1-5",
                                        "value"=> "1-5"
                                    ],
                                    [
                                        "label"=> "6-10",
                                        "value"=> "6-10"
                                    ],
                                    [
                                        "label"=> "11-15",
                                        "value"=> "11-15"
                                    ],
                                    [
                                        "label"=> "16-20",
                                        "value"=> "16-20"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Weekly Estimated Hours",
                        "name"=> "weekly_hours",
                        "multiple"=> false,
                        "forceRow"=> true,
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "type",
                                        "value"=> [
                                            "long"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "1-5",
                                        "value"=> "1-5"
                                    ],
                                    [
                                        "label"=> "6-10",
                                        "value"=> "6-10"
                                    ],
                                    [
                                        "label"=> "11-15",
                                        "value"=> "11-15"
                                    ],
                                    [
                                        "label"=> "16-20",
                                        "value"=> "16-20"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "other_hour",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "or",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "hours",
                                        "value"=> [
                                            "Other"
                                        ]
                                    ],
                                    [
                                        "type"=> "matches",
                                        "name"=> "weekly_hours",
                                        "value"=> [
                                            "Other"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "On A Bus Line?",
                        "name"=> "bus_route",
                        "multiple"=> false,
                        "forceRow"=> true,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "YES",
                                        "value"=> "YES"
                                    ],
                                    [
                                        "label"=> "NO",
                                        "value"=> "NO"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Number of People Needed",
                        "name"=> "num_participants",
                        "multiple"=> false,
                        "columns"=> 6,
                        "forceRow"=>true,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "1-2",
                                        "value"=> "1-2"
                                    ],
                                    [
                                        "label"=> "3-5",
                                        "value"=> "3-5"
                                    ],
                                    [
                                        "label"=> "6-10",
                                        "value"=> "6-10"
                                    ],
                                    [
                                        "label"=> "11-15",
                                        "value"=> "11-15"
                                    ],
                                    [
                                        "label"=> "16-20",
                                        "value"=> "16-20"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "other_people",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "num_participants",
                                        "value"=> [
                                            "Other"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "radio",
                        "label"=> "Days Preferred (Check All that Apply)",
                        "forceRow"=>true,
                        "name"=> "days",
                        "multiple"=> true,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Sunday",
                                        "value"=> "Sunday"
                                    ],
                                    [
                                        "label"=> "Monday",
                                        "value"=> "Monday"
                                    ],
                                    [
                                        "label"=> "Tuesday",
                                        "value"=> "Tuesday"
                                    ],
                                    [
                                        "label"=> "Wednesday",
                                        "value"=> "Wednesday"
                                    ],
                                    [
                                        "label"=> "Thursday",
                                        "value"=> "Thursday"
                                    ],
                                    [
                                        "label"=> "Friday",
                                        "value"=> "Friday"
                                    ],
                                    [
                                        "label"=> "Saturday",
                                        "value"=> "Saturday"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "type"=> "radio",
                        "label"=> "Time(s) of Day for Participation",
                        "name"=> "time",
                        "multiple"=> true,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Morning",
                                        "value"=> "Morning"
                                    ],
                                    [
                                        "label"=> "Afternoon",
                                        "value"=> "Afternoon"
                                    ],
                                    [
                                        "label"=> "Evening",
                                        "value"=> "Evening"
                                    ],
                                    [
                                        "label"=> "No Preference",
                                        "value"=> "No Preference"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "name"=> "desc",
                        "type"=> "textarea",
                        "label"=> "Description of Project and Tasks",
                        "required"=> true,
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Contact Info",
                "name"=> "contact_info",
                "showColumn"=>false,
                "fields"=> [
                    [
                        "type"=> "fieldset",
                        "label"=> "Primary Contact Information",
                        "name"=> "primary_contact",
                        "fields"=> [
                            [
                                "label"=> "Contact Name",
                                "name"=> "contact_name",
                                "columns"=> 6,
                                "required"=> true,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Phone Number",
                                "name"=> "contact_phone",
                                "columns"=> 6,
                                "required"=> true,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Contact Title",
                                "name"=> "contact_title",
                                "columns"=> 6,
                                "required"=> true,
                                "type"=> "text"
                            ],
                            [
                                "type"=> "email",
                                "label"=> "Email Address",
                                "name"=> "contact_email",
                                "columns"=> 6,
                                "required"=> true
                            ],
                            [
                                "label"=> "Mailing Address",
                                "name"=> "contact_address1",
                                "columns"=> 6,
                                "required"=> true,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Mailing Address (Continued)",
                                "name"=> "contact_address2",
                                "columns"=> 6,
                                "required"=> true,
                                "type"=> "text"
                            ]
                        ]
                    ],
                    [
                        "type"=> "fieldset",
                        "label"=> "Secondary Contact(Optional)",
                        "name"=> "secondary_contact",
                        "fields"=> [
                            [
                                "label"=> "Contact Name",
                                "name"=> "contact2_name",
                                "columns"=> 6,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Phone Number",
                                "name"=> "contact2_phone",
                                "columns"=> 6,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Contact Title",
                                "name"=> "contact2_title",
                                "columns"=> 6,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Email Address",
                                "name"=> "contact2_email",
                                "columns"=> 6,
                                "type"=> "email"
                            ],
                            [
                                "label"=> "Mailing Address",
                                "name"=> "contact2_address1",
                                "columns"=> 6,
                                "type"=> "text"
                            ],
                            [
                                "label"=> "Mailing Address (Continued)",
                                "name"=> "contact2_address2",
                                "columns"=> 6,
                                "type"=> "text"
                            ]
                        ]
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Participant Information",
                "name"=> "participant_information",
                "fields"=> [
                    [
                        "type"=> "radio",
                        "label"=> "Who would you like to involve? (Check all that apply)",
                        "name"=> "involved_people_type",
                        "multiple"=> true,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Undergraduate Students",
                                        "value"=> "Undergraduate Students"
                                    ],
                                    [
                                        "label"=> "Staff",
                                        "value"=> "Staff"
                                    ],
                                    [
                                        "label"=> "Alumni",
                                        "value"=> "Alumni"
                                    ],
                                    [
                                        "label"=> "Faculty",
                                        "value"=> "Faculty"
                                    ],
                                    [
                                        "label"=> "Graduate Students",
                                        "value"=> "Graduate Students"
                                    ],
                                    [
                                        "label"=> "No Preference",
                                        "value"=> "No Preference"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "involve_other",
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "contains",
                                        "name"=> "involved_people_type",
                                        "value"=> [
                                            "Other"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "radio",
                        "label"=> "To which area(s) of Binghamton University does this project/activity relate (so that we may inform them)? (Check all that apply)",
                        "name"=> "university_offices",
                        "multiple"=> true,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "Internship Offices",
                                        "value"=> "Internship Offices"
                                    ],
                                    [
                                        "label"=> "Volunteer Offices",
                                        "value"=> "Volunteer Offices"
                                    ],
                                    [
                                        "label"=> "Classes",
                                        "value"=> "Classes"
                                    ],
                                    [
                                        "label"=> "Student Clubs/Organizations",
                                        "value"=> "Student Clubs/Organizations"
                                    ],
                                    [
                                        "label"=> "Research Centers",
                                        "value"=> "Research Centers"
                                    ],
                                    [
                                        "label"=> "Academic Departments",
                                        "value"=> "Academic Departments"
                                    ],
                                    [
                                        "label"=> "Athletic Department",
                                        "value"=> "Athletic Department"
                                    ],
                                    [
                                        "label"=> "No Preference",
                                        "value"=> "No Preference"
                                    ],
                                    [
                                        "label"=> "Other University Offices",
                                        "value"=> "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "other_university_office",
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "contains",
                                        "name"=> "university_offices",
                                        "value"=> [
                                            "Other"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Project Requirements",
                "name"=> "project_requirements",
                "fields"=> [
                    [
                        "type"=> "select",
                        "label"=> "Is Training Required?",
                        "name"=> "reqs_training",
                        "multiple"=> false,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "NO",
                                        "value"=> "NO"
                                    ],
                                    [
                                        "label"=> "YES",
                                        "value"=> "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "specify_training",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "reqs_training",
                                        "value"=> [
                                            "YES"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Is Proof of Immunization Required?",
                        "name"=> "reqs_immune",
                        "multiple"=> false,
                        "forceRow"=> true,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "NO",
                                        "value"=> "NO"
                                    ],
                                    [
                                        "label"=> "YES",
                                        "value"=> "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "specify_immune",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "reqs_immune",
                                        "value"=> [
                                            "YES"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "select",
                        "label"=> "Application Required?",
                        "name"=> "reqs_application",
                        "multiple"=> false,
                        "forceRow"=> true,
                        "columns"=> 6,
                        "required"=> true,
                        "options"=> [
                            [
                                "label"=> "",
                                "type"=> "optgroup",
                                "options"=> [
                                    [
                                        "label"=> "NO",
                                        "value"=> "NO"
                                    ],
                                    [
                                        "label"=> "YES",
                                        "value"=> "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "label"=> "Please Specify",
                        "name"=> "specify_application",
                        "columns"=> 6,
                        "show"=> [
                            [
                                "op"=> "and",
                                "conditions"=> [
                                    [
                                        "type"=> "matches",
                                        "name"=> "reqs_application",
                                        "value"=> [
                                            "YES"
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        "required"=> "show",
                        "type"=> "text"
                    ],
                    [
                        "type"=> "textarea",
                        "label"=> "Other Requirements",
                        "name"=> "reqs_desc"
                    ]
                ]
            ],
//            [
//                "name"=> "website",
//                "type"=> "text",
//                "label"=> "Organization Website"
//            ],
//            [
//                "name"=> "type",
//                "type"=> "select",
//                "label"=> "Type",
//                "options"=> [
//                    [
//                        "type"=> "optgroup",
//                        "label"=> "",
//                        "options"=> [
//                            [
//                                "label"=> "Government",
//                                "value"=> "Government"
//                            ],
//                            [
//                                "label"=> "Non-profit",
//                                "value"=> "Non-profit"
//                            ],
//                            [
//                                "label"=> "Business/Corporation",
//                                "value"=> "Business/Corporation"
//                            ],
//                            [
//                                "label"=> "Student Organization",
//                                "value"=> "Student Organization"
//                            ],
//                            [
//                                "label"=> "Faculty",
//                                "value"=> "Faculty"
//                            ],
//                            [
//                                "label"=> "Other",
//                                "value"=> "Other"
//                            ]
//                        ]
//                    ]
//                ]
//            ]
        ];
        return $fields;
    }

}
