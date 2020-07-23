<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Organization extends Authenticatable
{
    protected $primaryKey = 'key';
    protected $table = "orgs";
    protected $hidden = ['passcode','remember_token'];
    public $timestamps = false;
    protected $fillable = [
        'key','org_code','name','address1','address2','website','passcode','type','desc','fields','shown',
        'contact_name','contact_phone','contact_title','contact_email','contact_address1','contact_address2',
        'contact2_name','contact2_phone','contact2_title','contact2_email','contact2_address1','contact2_address2',
    ];

    public function listings() {
        return $this->hasMany(Listing::class);
    }

//    static public function addNewOrganization($request){
//        $organization = [

//            //Organization Information
//            'name'=>$request->organization_information["name"],
//            'address1'=>$request->organization_information["address1"],
//            'address2'=>$request->organization_information["address2"],
//            'website'=>$request->organization_information["website"],
//            'type'=>$request->organization_information["type"],
//            'desc'=>$request->organization_information["desc"],
//            'fields'=>implode(", ",$request->organization_information["fields"]),
//
//            //Primary Contact
//            'contact_name'=>$request->primary_contact["contact_name"],
//            'contact_phone'=>$request->primary_contact["contact_phone"],
//            'contact_title'=>$request->primary_contact["contact_title"],
//            'contact_email'=>$request->primary_contact["contact_email"],
//            'contact_address1'=>$request->primary_contact["contact_address1"],
//            'contact_address2'=>$request->primary_contact["contact_address2"],
//
//            //Secondary Contact
//            'contact2_name'=>$request->secondary_contact["contact2_name"],
//            'contact2_phone'=>$request->secondary_contact["contact2_phone"],
//            'contact2_title'=>$request->secondary_contact["contact2_title"],
//            'contact2_email'=>$request->secondary_contact["contact2_email"],
//            'contact2_address1'=>$request->secondary_contact["contact2_address1"],
//            'contact2_address2'=>$request->secondary_contact["contact2_address2"]
//        ];
////        $organization->org_code = $organization->key;
////        return $organization;
//
//        return $organization;
//    }

    public function updateOrganization($request){
        $this->update([
//            'key'=>$request->key,
//            'org_code'=>$request->org_code,

            //Organization Information
            'name'=>$request->organization_information["name"],
            'address1'=>$request->organization_information["address1"],
            'address2'=>$request->organization_information["address2"],
            'website'=>$request->organization_information["website"],
            'type'=>$request->organization_information["type"],
            'desc'=>$request->organization_information["desc"],
            'fields'=>implode(", ",$request->organization_information["fields"]),

            //Primary Contact
            'contact_name'=>$request->primary_contact["contact_name"],
            'contact_phone'=>$request->primary_contact["contact_phone"],
            'contact_title'=>$request->primary_contact["contact_title"],
            'contact_email'=>$request->primary_contact["contact_email"],
            'contact_address1'=>$request->primary_contact["contact_address1"],
            'contact_address2'=>$request->primary_contact["contact_address2"],

            //Secondary Contact
            'contact2_name'=>$request->secondary_contact["contact2_name"],
            'contact2_phone'=>$request->secondary_contact["contact2_phone"],
            'contact2_title'=>$request->secondary_contact["contact2_title"],
            'contact2_email'=>$request->secondary_contact["contact2_email"],
            'contact2_address1'=>$request->secondary_contact["contact2_address1"],
            'contact2_address2'=>$request->secondary_contact["contact2_address2"]
        ]);
    }

    public function getOrganization($organization){
        return [
            'key'=>$organization->key,
            'org_code'=>$organization->org_code,
            "organization_information"=>[
                'name'=>$organization->name,
                'address1'=>$organization->address1,
                'address2'=>$organization->address2,
                'website'=>$organization->website,
                'type'=>$organization->type,
                'desc'=>$organization->desc,
                'fields'=>explode(", ",$organization->fields)
            ],
            'primary_contact'=>[
                'contact_name'=>$organization->contact_name,
                'contact_phone'=>$organization->contact_phone,
                'contact_title'=>$organization->contact_title,
                'contact_email'=>$organization->contact_email,
                'contact_address1'=>$organization->contact_address1,
                'contact_address2'=>$organization->contact_address2
            ],
            'secondary_contact'=>[
                'contact2_name'=>$organization->contact2_name,
                'contact2_phone'=>$organization->contact2_phone,
                'contact2_title'=>$organization->contact2_title,
                'contact2_email'=>$organization->contact2_email,
                'contact2_address1'=>$organization->contact2_address1,
                'contact2_address2'=>$organization->contact2_address2
            ]
        ];
    }



    static public function get_fields() {
        $fields = [
            [
                "type"=> "hidden",
                "name"=> "key"
            ],
            [
                "type"=> "hidden",
                "name"=> "org_code"
            ],
            [
                "type"=> "hidden",
                "name"=> "remember_token"
            ],
            [
                "type"=> "fieldset",
                "label"=> "Organization Information",
                "name"=> "organization_information",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "name",
                        "label"=> "Name of Organization"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "address1",
                        "label"=> "Mailing Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "address2",
                        "label"=> "Mailing Address (Continued)"
                    ],
                    [
                        "type"=> "url",
                        "name"=> "website",
                        "value"=>"http://",
                        "label"=> "Organization Website"
                    ],
                    [
                        "type"=> "select",
                        "name"=> "type",
                        "label"=> "Type",
                        "options"=> [
                            [
                                "options"=> [
                                    [
                                        "label"=> "Government",
                                        "value"=> "Government"
                                    ],
                                    [
                                        "label"=> "Non-profit",
                                        "value"=> "Non-profit"
                                    ],
                                    [
                                        "label"=> "Business/Corporation",
                                        "value"=> "Business/Corporation"
                                    ],
                                    [
                                        "label"=> "Student Organization",
                                        "value"=> "Student Organization"
                                    ],
                                    [
                                        "label"=> "Faculty",
                                        "value"=> "Faculty"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ],
                                "type"=> "optgroup",
                                "label"=> ""
                            ]
                        ]
                    ],
                    [
                        "type"=> "textarea",
                        "name"=> "desc",
                        "label"=> "Organization Description"
                    ],
                    [
                        "type"=> "radio",
                        "name"=> "fields",
                        "label"=> "Project Field(s) of Work (Check all that apply)",
                        "multiple"=> true,
                        "options"=> [
                            [
                                "options"=> config('app.categories'),
                                "type"=> "optgroup",
                            ]
                        ]
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Primary Contact",
                "name"=> "primary_contact",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "contact_name",
                        "label"=> "Contact Name"
                    ],
                    [
                        "type"=> "tel",
                        "name"=> "contact_phone",
                        "label"=> "Phone Number"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_title",
                        "label"=> "Contact Title"
                    ],
                    [
                        "type"=> "email",
                        "name"=> "contact_email",
                        "label"=> "Email Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_address1",
                        "label"=> "Mailing Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_address2",
                        "label"=> "Mailing Address (Continued)"
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Secondary Contact",
                "name"=> "secondary_contact",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "contact2_name",
                        "label"=> "Contact Name"
                    ],
                    [
                        "type"=> "tel",
                        "name"=> "contact2_phone",
                        "label"=> "Phone Number"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_title",
                        "label"=> "Contact Title"
                    ],
                    [
                        "type"=> "email",
                        "name"=> "contact2_email",
                        "label"=> "Email Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_address1",
                        "label"=> "Mailing Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_address2",
                        "label"=> "Mailing Address (Continued)"
                    ]
                ]
            ]
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
    static public function get_password_fields(){
        return [
            [
                "type"=> "password",
                "name"=> "passcode",
                "label"=> "Password"
            ],
            [
                "type"=> "password",
                "name"=> "confirm_passcode",
                "label"=> "Confirm Password",
                "validate"=> [
                    [
                        "type"=> "matches",
                        "name"=> "passcode",
                        "conditions"=> true
                    ]
			    ],
            ]
        ];
    }
    static public function get_register_organization_fields(){
        return [
            [
                "type"=> "hidden",
                "name"=> "key"
            ],
//            [
//                "type"=> "text",
//                "name"=> "org_code"
//            ],
            [
                "type"=> "password",
                "name"=> "passcode",
                "label"=> "Password",
                "required"=>true
            ],
            [
                "type"=> "password",
                "name"=> "confirm_passcode",
                "label"=> "Confirm Password",
                "required"=>true,
                "validate"=> [
                    [
                        "type"=> "matches",
                        "name"=> "passcode",
                        "conditions"=> true
                    ]
                ],
            ],
            [
                "type"=> "hidden",
                "name"=> "remember_token"
            ],
            [
                "type"=> "fieldset",
                "label"=> "Organization Information",
                "name"=> "organization_information",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "name",
                        "label"=> "Name of Organization",
                        "required"=>true
                    ],
                    [
                        "type"=> "text",
                        "name"=> "address1",
                        "label"=> "Mailing Address",
                        "required"=>true,
                    ],
                    [
                        "type"=> "text",
                        "name"=> "address2",
                        "label"=> "Mailing Address (Continued)",
                        "required"=>true
                    ],
                    [
                        "type"=> "url",
                        "name"=> "website",
                        "value"=>"http://",
                        "required"=>true,
                        "label"=> "Organization Website"
                    ],
                    [
                        "type"=> "select",
                        "name"=> "type",
                        "label"=> "Type",
                        "required"=>true,
                        "options"=> [
                            [
                                "options"=> [
                                    [
                                        "label"=> "Government",
                                        "value"=> "Government"
                                    ],
                                    [
                                        "label"=> "Non-profit",
                                        "value"=> "Non-profit"
                                    ],
                                    [
                                        "label"=> "Business/Corporation",
                                        "value"=> "Business/Corporation"
                                    ],
                                    [
                                        "label"=> "Student Organization",
                                        "value"=> "Student Organization"
                                    ],
                                    [
                                        "label"=> "Faculty",
                                        "value"=> "Faculty"
                                    ],
                                    [
                                        "label"=> "Other",
                                        "value"=> "Other"
                                    ]
                                ],
                                "type"=> "optgroup",
                                "label"=> ""
                            ]
                        ]
                    ],
                    [
                        "type"=> "textarea",
                        "name"=> "desc",
                        "required"=>true,
                        "label"=> "Organization Description"
                    ],
                    [
                        "type"=> "radio",
                        "name"=> "fields",
                        "label"=> "Project Field(s) of Work (Check all that apply)",
                        "multiple"=> true,
                        "required"=>true,
                        "options"=> [
                            [
                                "options"=> config('app.categories'),
                                "type"=> "optgroup",
                            ]
                        ]
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Primary Contact",
                "name"=> "primary_contact",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "contact_name",
                        "required"=>true,
                        "label"=> "Contact Name"
                    ],
                    [
                        "type"=> "tel",
                        "name"=> "contact_phone",
                        "required"=>true,
                        "label"=> "Phone Number"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_title",
                        "required"=>true,
                        "label"=> "Contact Title"
                    ],
                    [
                        "type"=> "email",
                        "name"=> "contact_email",
                        "required"=>true,
                        "label"=> "Email Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_address1",
                        "required"=>true,
                        "label"=> "Mailing Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact_address2",
                        "required"=>true,
                        "label"=> "Mailing Address (Continued)"
                    ]
                ]
            ],
            [
                "type"=> "fieldset",
                "label"=> "Secondary Contact",
                "name"=> "secondary_contact",
                "fields"=> [
                    [
                        "type"=> "text",
                        "name"=> "contact2_name",
                        "label"=> "Contact Name"
                    ],
                    [
                        "type"=> "tel",
                        "name"=> "contact2_phone",
                        "label"=> "Phone Number"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_title",
                        "label"=> "Contact Title"
                    ],
                    [
                        "type"=> "email",
                        "name"=> "contact2_email",
                        "label"=> "Email Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_address1",
                        "label"=> "Mailing Address"
                    ],
                    [
                        "type"=> "text",
                        "name"=> "contact2_address2",
                        "label"=> "Mailing Address (Continued)"
                    ]
                ]
            ]
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
    }

}
