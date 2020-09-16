@extends('default')

@section('title', 'Manage Organization and Listings')
@section('description')
    @if((config('templates.page.manage.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.manage.alert') !!}
        </div>
    @endif
    This page provides a portal for organizations and service groups to
    manage their organization page and project listings from one convenient
    location.
@endsection

@section('content')
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
            "required":true,
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
        {"type":"save","action":"save","label":"Submit","modifiers":"btn btn-primary"},
        {"type":"cancel","action":"cancel","label":"Register","modifiers":"btn btn-default"},
        {"type":"button","action":"reset_this","label":"Forgot Your Password?","modifiers":"btn btn-default"}
    ]}
).on('save',function(form_event) {
    if(form_event.form.validate())
        {
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
    }else{
        toastr.error("Please ensure that all required fields have been populated!")
        }
})
.on('cancel',function(){
    new gform({"fields": {!! json_encode($register_organization) !!} }).modal()
    .on('save',function(form_event) {
        if(form_event.form.validate()){
            var form_data = form_event.form.get();
            console.log(form_event.form.get());
            $.ajax({
                type: "POST",
                url: root_url+"/api/orgauth/register",
                data: form_event.form.get(),
                success: function(response) {
                    toastr.success('Welcome '+response.name);
                    window.location = root_url+"/manage";
                },
                error: function(response) {
                toastr.error(response);
                }
            });
        }
    })
    .on('cancel',function(form_event) {
        form_event.form.trigger('close');
    })
{{--console.log("ali Kemal");--}}
})
.on('reset_this',function(form_event){
    var form_data = form_event.form.get();
    if(form_event.form.validate()){
        $.ajax({
            type: "POST",
            url: root_url+"/api/password/"+form_data.organization,
            success: function(response) {
                toastr.success('Your reset link has been sent to your email');
            },
            error: function(response) {
                toastr.error("<b>Error!</b><br>Please make sure you selected a valid organization.");
            }
        });
    }else{
        toastr.error("Please ensure that all required fields have been populated!")
        }
});
@endsection
