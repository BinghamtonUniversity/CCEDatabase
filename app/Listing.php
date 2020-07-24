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

    public function update_from_form($form_data){
        $this->key=$form_data["key"];
        $this->website=$form_data["website"];
        $this->type=$form_data["project_information"]["type"];
        $this->title=$form_data["project_information"]["title"];
        $this->location=$form_data["project_information"]["location"];
        $this->location2=$form_data["project_information"]["location2"];
        $this->category=implode(", ",$form_data["project_information"]["category"]);
        $this->bus_route=$form_data["project_information"]["bus_route"];
        $this->num_participants=$form_data["project_information"]["num_participants"]==="Other"?$form_data["project_information"]["other_people"]:$form_data["project_information"]["num_participants"];
        $this->ongoing=$form_data["project_information"]["ongoing"]==1;
        $this->start_date=isset($form_data["project_information"]["start_date"])?(date('Y-m-d',strtotime($form_data["project_information"]["start_date"]))):null;
        $this->end_date=isset($form_data["project_information"]["end_date"])?(date('Y-m-d',strtotime($form_data["project_information"]["end_date"]))):null;
        $this->fields=implode(", ",$form_data["project_information"]["fields"]);
        $this->paid=($form_data["project_information"]["paid"]==="YES")?$form_data["project_information"]["paid"]."<-|->".$form_data["project_information"]["paid_amount"]:$form_data["project_information"]["paid"]."<-|->";

        $this->days=implode(", ",$form_data["project_information"]["days"]);
        $this->desc=$form_data["project_information"]["desc"];
        $this->time=implode(", ",$form_data["project_information"]["time"]);

        $this->contact_name=$form_data["contact_info"]["primary_contact"]["contact_name"];
        $this->contact_title=$form_data["contact_info"]["primary_contact"]["contact_title"];
        $this->contact_email=$form_data["contact_info"]["primary_contact"]["contact_email"];
        $this->contact_phone=$form_data["contact_info"]["primary_contact"]["contact_phone"];
        $this->contact_address1=$form_data["contact_info"]["primary_contact"]["contact_address1"];
        $this->contact_address2=$form_data["contact_info"]["primary_contact"]["contact_address2"];

        $this->contact2_name=$form_data["contact_info"]["secondary_contact"]["contact2_name"];
        $this->contact2_title=$form_data["contact_info"]["secondary_contact"]["contact2_title"];
        $this->contact2_email=$form_data["contact_info"]["secondary_contact"]["contact2_email"];
        $this->contact2_phone=$form_data["contact_info"]["secondary_contact"]["contact2_phone"];
        $this->contact2_address1=$form_data["contact_info"]["secondary_contact"]["contact2_address1"];
        $this->contact2_address2=$form_data["contact_info"]["secondary_contact"]["contact2_address2"];

        $this->reqs_training=($form_data["project_requirements"]["reqs_training"]==="YES")?$form_data["project_requirements"]["reqs_training"]."<-|->".$form_data["project_requirements"]["specify_training"]:$form_data["project_requirements"]["reqs_training"]."<-|->";
        $this->reqs_immune=($form_data["project_requirements"]["reqs_immune"]==="YES")?$form_data["project_requirements"]["reqs_immune"]."<-|->".$form_data["project_requirements"]["specify_immune"]:$form_data["project_requirements"]["reqs_immune"]."<-|->";
        $this->reqs_application=($form_data["project_requirements"]["reqs_application"]==="YES")?$form_data["project_requirements"]["reqs_application"]."<-|->".$form_data["project_requirements"]["specify_application"]:$form_data["project_requirements"]["reqs_application"]."<-|->";
        $this->reqs_desc=$form_data["project_requirements"]["reqs_desc"];

        //Other Hours Handling
        if($form_data["project_information"]["type"]==="short"){
            if($form_data["project_information"]["hours"]==="Other"){
                $this->hours=$form_data["project_information"]["other_hour"];
            } else{
                $this->hours=$form_data["project_information"]["hours"];
            }
        }
        if($form_data["project_information"]["type"]==="long"){
            if($form_data["project_information"]["weekly_hours"]==="Other"){
                $this->hours=$form_data["project_information"]["other_hour"];
            } else{
                $this->hours=$form_data["project_information"]["weekly_hours"];
            }
        }

        //Other Participants Handling
        $temp_array = [];
        foreach($form_data["participant_information"]["involved_people_type"] as $participant){
            if($participant === "Other"){
                $temp_array[]=$form_data["participant_information"]["involve_other"];
            } else{
                $temp_array[]=$participant;
            }
        }
        $this->participants=implode(", ",$temp_array);

        //Other University Offices Handling
        $temp_array = [];
        foreach($form_data["participant_information"]["university_offices"] as $office){
            if($office === "Other"){
                $temp_array[]=$form_data["participant_information"]["other_university_office"];
            } else{
                $temp_array[]=$office;
            }
        }
        $this->related=implode(", ",$temp_array);
        $this->save();
    }

    public function get_form_data(){

        /* These "arrays" should be rewritten in a way that isn't super specific to the data 
           object.  Any change to the form definition and this whole thing breaks */

        //To get the value in Involved People Field
        $involved_people_array = array_column(config('form_fields.listing')[4]["fields"][0]["options"][0]["options"],"value");
        //To get the value in University Offices Field
        $offices_array = array_column(config('form_fields.listing')[4]["fields"][2]["options"][0]["options"],"value");

        //Get hours defined in the form definition
        $hours_array = array_column(config('form_fields.listing')[2]["fields"][13]["options"][0]["options"],"value");

        //Get the participants defined in the form definition
        $num_participants_array = array_column(config('form_fields.listing')[2]["fields"][16]["options"][0]["options"],"value");

        $form_data = [
            "key"=>$this->key,
            "org_code"=>$this->org_code,
            "website"=>$this->website,
            "project_information"=>[
                "type"=>$this->type,
                "title"=>$this->title,
                "location"=>$this->location,
                "location2"=>$this->location2,
                "category"=>explode(", ",$this->category),
                "bus_route"=>$this->bus_route,
                "ongoing"=>$this->ongoing===0?false:true,
                "start_date"=>$this->ongoing===0?date('m-d-Y', strtotime($this->start_date)):null,
                "end_date"=>$this->ongoing===0?date('m-d-Y', strtotime($this->end_date)):null,
                "fields"=>explode(", ",$this->fields),
                "paid"=>explode("<-|->",$this->paid)[0],
                "paid_amount"=>explode("<-|->",$this->paid)[1],
                "hours"=>$this->type==="short"?in_array($this->hours,$hours_array)?$this->hours:"Other":null,
                "weekly_hours"=>$this->type==="long"?in_array($this->hours,$hours_array)?$this->hours:"Other":null,
                "other_hour"=> in_array($this->hours,$hours_array)?null:$this->hours,
                "num_participants"=>in_array($this->num_participants,$num_participants_array)?$this->num_participants:"Other",
                "other_people"=>in_array($this->num_participants,$num_participants_array)?null:$this->num_participants,
                "days"=>explode(", ",$this->days),
                "desc"=>$this->desc,
                "time"=>explode(", ",$this->time)
            ],
            "contact_info"=>[
                "primary_contact"=>[
                    "contact_name"=>$this->contact_name,
                    "contact_title"=>$this->contact_title,
                    "contact_email"=>$this->contact_email,
                    "contact_phone"=>$this->contact_phone,
                    "contact_address1"=>$this->contact_address1,
                    "contact_address2"=>$this->contact_address2,
                ],
                "secondary_contact"=>[
                    "contact2_name"=>$this->contact2_name,
                    "contact2_title"=>$this->contact2_title,
                    "contact2_email"=>$this->contact2_email,
                    "contact2_phone"=>$this->contact2_phone,
                    "contact2_address1"=>$this->contact2_address1,
                    "contact2_address2"=>$this->contact2_address2
                ]
            ],
            "project_requirements"=>[
                "reqs_training"=>explode("<-|->",$this->reqs_training)[0],
                "specify_training"=>explode("<-|->",$this->reqs_training)[0]==="YES"?explode("<-|->",$this->reqs_training)[1]:null,
                "reqs_immune"=>explode("<-|->",$this->reqs_immune)[0],
                "specify_immune"=>explode("<-|->",$this->reqs_immune)[0]==="YES"?explode("<-|->",$this->reqs_immune)[1]:null,
                "reqs_application"=>explode("<-|->",$this->reqs_application)[0],
                "specify_application"=>explode("<-|->",$this->reqs_application)[0]==="YES"?explode("<-|->",$this->reqs_application)[1]:null,
                "reqs_desc"=>$this->reqs_desc
            ]
        ];

        //Looking for Other in Involved People
        $result_array = [];
        foreach (explode(", ",$this->participants) as $participant){
            if(in_array($participant,$involved_people_array)){
                $result_array[]=$participant;
            }
            else{
                $result_array[] = "Other";
                $form_data["participant_information"]["involve_other"] = $participant;
            }
        }
        $form_data["participant_information"]["involved_people_type"] = $result_array;

        //Looking for Other in Related University Offices
        $result_array=[];
        foreach (explode(", ",$this->related) as $related_office){
            if(in_array($related_office,$offices_array)){
                $result_array[]=$related_office;
            } else {
                $result_array[] = "Other";
                $form_data["participant_information"]["other_university_office"] = $related_office;
            }
        }
        $form_data["participant_information"]["university_offices"] = $result_array;

        return $form_data;
    }
    static public function get_fields() {
        return config('form_fields.listing');
    }

}
