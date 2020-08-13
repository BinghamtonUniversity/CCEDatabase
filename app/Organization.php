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

    public function update_from_form($organization_arr){
        //Organization Information
        $this->name=$organization_arr["organization_information"]["name"];
        $this->address1=$organization_arr["organization_information"]["address1"];
        $this->address2=$organization_arr["organization_information"]["address2"];
        $this->website=$organization_arr["organization_information"]["website"];
        $this->type=$organization_arr["organization_information"]["type"];
        $this->desc=$organization_arr["organization_information"]["desc"];
        $this->fields=implode(", ",$organization_arr["organization_information"]["fields"]);

        //Primary Contact
        $this->contact_name=$organization_arr["primary_contact"]["contact_name"];
        $this->contact_phone=$organization_arr["primary_contact"]["contact_phone"];
        $this->contact_title=$organization_arr["primary_contact"]["contact_title"];
        $this->contact_email=$organization_arr["primary_contact"]["contact_email"];
        $this->contact_address1=$organization_arr["primary_contact"]["contact_address1"];
        $this->contact_address2=$organization_arr["primary_contact"]["contact_address2"];

        //Secondary Contact
        $this->contact2_name=$organization_arr["secondary_contact"]["contact2_name"];
        $this->contact2_phone=$organization_arr["secondary_contact"]["contact2_phone"];
        $this->contact2_title=$organization_arr["secondary_contact"]["contact2_title"];
        $this->contact2_email=$organization_arr["secondary_contact"]["contact2_email"];
        $this->contact2_address1=$organization_arr["secondary_contact"]["contact2_address1"];
        $this->contact2_address2=$organization_arr["secondary_contact"]["contact2_address2"];
        $this->save();
    }

    public function get_form_data() {
        return [
            'key'=>$this->key,
            'shown'=>$this->shown===1?true:false,
            'org_code'=>$this->org_code,
            "organization_information"=>[
                'name'=>$this->name,
                'address1'=>$this->address1,
                'address2'=>$this->address2,
                'website'=>$this->website,
                'type'=>$this->type,
                'desc'=>$this->desc,
                'fields'=>explode(", ",$this->fields)
            ],
            'primary_contact'=>[
                'contact_name'=>$this->contact_name,
                'contact_phone'=>$this->contact_phone,
                'contact_title'=>$this->contact_title,
                'contact_email'=>$this->contact_email,
                'contact_address1'=>$this->contact_address1,
                'contact_address2'=>$this->contact_address2
            ],
            'secondary_contact'=>[
                'contact2_name'=>$this->contact2_name,
                'contact2_phone'=>$this->contact2_phone,
                'contact2_title'=>$this->contact2_title,
                'contact2_email'=>$this->contact2_email,
                'contact2_address1'=>$this->contact2_address1,
                'contact2_address2'=>$this->contact2_address2
            ]
        ];
    }

    static public function get_fields() {
        return config('form_fields.organization');
    }
    static public function get_password_fields(){
        return config('form_fields.password');
    }
    static public function get_register_organization_fields(){
        return array_merge(config('form_fields.organization'),config('form_fields.password'));
    }

}
