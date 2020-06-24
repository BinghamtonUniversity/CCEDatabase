@extends('default')

@section('title', 'Manage Organization and Listings')
@section('description','This page provides a portal for organizations and service groups to manage their organization page and project listings from one convenient location.')

@section('content')
<div>
    <a href="{{url('/manage/logout')}}" class="btn btn-danger pull-right">Logout</a>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div id="org-admin-login"></div>
    </div>
</div>
@endsection

@section('scripts')
// Login Form
new gform(
    {"el":"#org-admin-login",
    "fields": [
		{
			"type": "smallcombo",
			"label": "Select Your Organization",
			"name": "organization",
			"multiple": false,
			"options": [
				{
					"type": "optgroup",
					"path": root_url+'/api/organizations/list'
				}
			]
		},
		{
			"type": "password",
			"label": "Password",
			"name": "password"
		}
	],
    "actions":[
        {"type":"save","label":"Submit","modifiers":"btn btn-primary"},
    ]}
).on('save',function(form_event) {
    $.ajax({
        type: "POST",
        url: root_url+"/api/orgauth/authenticate",
        data: form_event.form.get(),
        success: function(response) {
            toastr.success('Welcome '+response.name);
            window.location = root_url+"/manage";
        },
        error: function(response) {
            toastr.error('Permission Denied!');
        }
    });
});
@endsection