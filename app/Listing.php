<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $primaryKey = 'key';
    protected $table = "listings";
    public $timestamps = false; 

    public function organization() {
        return $this->belongsTo(Organization::class,'org_code','org_code');
    }
    static public function get_fields() {
        $fields = [
            [
                "type"=>"hidden",
                "name"=>"key"
            ],
            [
                "type"=>"select",
                "label"=>"Project Type",
                "name"=>"type",
                "options"=> [
                    ["label"=>"Short Term (Lasting Less that a Week)", "value"=>"short"],
                    ["label"=>"Long Term (Lasting More than a Week, or periodically over a long period)", "value"=>"long"],
                ]
            ],
            [
                "type"=>"text",
                "name"=>"title",
                "label"=>"Title of Project Listing"
            ],
            [
                "type"=>"text",
                "name"=>"address",
                "label"=>"Location of Project (Valid Address)"
            ],
            [
                "type"=>"text",
                "name"=>"location2",
                "label"=>"Location of Project (Continued)"
            ],
            [
                "type"=>"select",
                "name"=>"category",
                "label"=>"Category",
                "options"=> ["Internship","Research","Service","Group Project","Academic Service Learning Class","Other"]
            ],
            [
                "type"=>"checkbox",
                "name"=>"ongoing",
                "label"=>"Ongoing",
            ],
            [
                "type"=>"date",
                "name"=>"start_date",
                "label"=>"Project Start Date",
            ],
            [
                "type"=>"date",
                "name"=>"end_date",
                "label"=>"Project End Date",
            ],
            [
                "type"=>"select",
                "name"=>"fields",
                "label"=>"Project Field(s) of Work (Check all that apply)",
                "options"=> config('app.categories')
            ],
            [
                "type"=>"select",
                "name"=>"paid",
                "label"=>"Paid?",
                "options"=>["YES","NO"]
            ],
            [
                "type"=>"select",
                "name"=>"bus_route",
                "label"=>"On A Bus Line?",
                "options"=>["YES","NO"]
            ],
            [
                "type"=>"select",
                "name"=>"hours",
                "label"=>"Total Estimated Hours",
                "options"=>["1-5","6-10","11-15","16-20"]
            ],
            [
                "type"=>"select",
                "name"=>"num_participants",
                "label"=>"Number of People Needed",
                "options"=>["1-5","6-10","11-15","16-20"]
            ],
            [
                "type"=>"select",
                "name"=>"days",
                "label"=>"Days Preferred (Check All that Apply)",
                "options"=>["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]
            ],
            [
                "type"=>"select",
                "name"=>"times",
                "label"=>"Time(s) of Day for Participation",
                "options"=>["Morning","Afternoon","Evening","No Preference"]
            ],
            [
                "type"=>"textarea",
                "name"=>"desc",
                "label"=>"Description of Project and Tasks"
            ],
            // Contact Info Section
            [
                "type"=>"text",
                "name"=>"contact_name",
                "label"=>"Contact Name"
            ],
            [
                "type"=>"text",
                "name"=>"contact_phone",
                "label"=>"Phone Number"
            ],
            [
                "type"=>"text",
                "name"=>"contact_title",
                "label"=>"Contact Title"
            ],
            [
                "type"=>"text",
                "name"=>"contact_email",
                "label"=>"Email Address"
            ],
            [
                "type"=>"text",
                "name"=>"contact_address1",
                "label"=>"Mailing Address"
            ],
            [
                "type"=>"text",
                "name"=>"contact_address2",
                "label"=>"Mailing Address (Continued)"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_name",
                "label"=>"Contact Name"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_phone",
                "label"=>"Phone Number"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_title",
                "label"=>"Contact Title"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_email",
                "label"=>"Email Address"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_address1",
                "label"=>"Mailing Address"
            ],
            [
                "type"=>"text",
                "name"=>"contact2_address2",
                "label"=>"Mailing Address (Continued)"
            ],
            // Participant Information Section
            [
                "type"=>"text",
                "name"=>"website",
                "label"=>"Organization Website"
            ],
            [
                "type"=>"select",
                "name"=>"type",
                "label"=>"Type",
                "options"=> ["Government","Non-profit","Business/Corporation","Student Organization","Faculty","Other"]
            ],
            // [
            //     "type"=>"select",
            //     "name"=>"shown",
            //     "label"=>"Visibility",
            //     "options"=> [
            //         ["label"=>"Hide Organization","value"=>0],
            //         ["label"=>"Show Organization","value"=>1]
            //     ]
            // ],
        ];
        return $fields;
    }
  
}
