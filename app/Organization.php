<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Organization extends Authenticatable
{
    protected $primaryKey = 'key';
    protected $table = "orgs";
    protected $hidden = ['passcode','remeber_token'];
    public $timestamps = false; 
    protected $fillable = [
        'key','name','address1','address2','website','type','desc','fields','shown',
        'contact_name','contact_phone','contact_title','contact_email','contact_address1','contact_address2',
        'contact2_name','contact2_phone','contact2_title','contact2_email','contact2_address1','contact2_address2',
    ];

    public function listings() {
        return $this->hasMany(Listing::class);
    }
    static public function get_fields() {
        $fields = [
            [
                "type"=>"hidden",
                "name"=>"key"
            ],
            [
                "type"=>"text",
                "name"=>"name",
                "label"=>"Name of Organization"
            ],
            [
                "type"=>"text",
                "name"=>"address1",
                "label"=>"Mailing Address"
            ],
            [
                "type"=>"text",
                "name"=>"address2",
                "label"=>"Mailing Address (Continued)"
            ],
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
            [
                "type"=>"textarea",
                "name"=>"desc",
                "label"=>"Organization Description"
            ],
            [
                "type"=>"select",
                "name"=>"fields",
                "label"=>"Project Field(s) of Work (Check all that apply)",
                "options"=> config('app.categories')
            ],
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
