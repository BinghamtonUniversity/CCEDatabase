@extends('default')

@section('title',"Manage: ".Auth::user()->name)
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
<div>
    <a href="{{url('/manage/logout')}}" class="btn btn-danger pull-right">Logout</a>
</div>

<div id="org-admin-update-org-btn" class="btn btn-primary">Update My Organization</div>
<div id="org-admin-password-update-btn" class="btn btn-default">Update My Password</div>
<div class="alert alert-info" style="margin-top:15px;">
    <h3>Instructions:</h3>
    Use the <div class="btn btn-success btn-xs">New</div> button below to create a new project listing.  <br>
    Select the <i class="fa fa-check-square-o"></i> next to the listing you want to modify and click <div class="btn btn-primary btn-xs">Edit</div> or <div class="btn btn-danger btn-xs">Delete</div>
</div>
<div id="org-admin-update-listings"></div>


@endsection

@section('scripts')
// Edit Organization
$(document).ready(function() {
    $('#org-admin-update-org-btn').on('click',function() {
        $.ajax({
            type: "GET",
            url: root_url+"/api/organizations/{{Auth::user()->key}}",
            success: function(orginfo) {
                console.log(orginfo);
                new gform({
                    "fields": {!! json_encode($organization_fields) !!},
                    "data": orginfo,
                }).modal().on('save',function(form_event) {
                    var form_data = form_event.form.get();
                    if (form_event.form.validate())
                        {
                            $.ajax({
                                type: "PUT",
                                url: root_url+"/api/organizations/"+form_data.key,
                                data: form_event.form.get(),
                                success: function(response) {
                                    toastr.success(response.organization_information.name+' Info Updated!');
                                    form_event.form.trigger('close')
                                },
                                error: function(response) {
                                    toastr.error('There was an error!');
                                }
                        });
                    }else{
                        toastr.error("Please ensure that all required fields have been populated!")
                        }
                }).on('cancel',function(form_event) {
                    form_event.form.trigger('close');
                })
            }
        });
    });
});

$('#org-admin-password-update-btn').on('click',function() {
    new gform({"fields": {!! json_encode($organization_password_change) !!} }).modal()
    .on('save',function(form_event) {
        if(form_event.form.validate()){
            var form_data = form_event.form.get();
            console.log(form_event.form.get());
            $.ajax({
                type: "PUT",
                url: root_url+"/api/password_update/"+{{Auth::user()->key}},
                data: form_event.form.get(),
                success: function(response) {
                    toastr.success("Password Updated");
                    form_event.form.trigger('close')
                },
                error: function(response) {
                toastr.error(response);
                }
            });
        }else{
            toastr.error("Please ensure that all required fields have been populated!")
            }
    })
    .on('cancel',function(form_event) {
    form_event.form.trigger('close');
    })
});

// Edit Listings// Edit Listings
$.ajax({
    type: "GET",
    url: root_url+"/api/organizations/{{Auth::user()->key}}/listings",
    success: function(listings) {
        console.log(listings);
        gdg = new GrapheneDataGrid({el:'#org-admin-update-listings',
        search: false,columns: false,upload:false,download:false,title:'Users',
        entries:[],
        count:20,
        schema:{!! json_encode($listing_fields) !!},
        data: listings
        }).on("model:created",function(grid_event) {
            console.log(grid_event.model.attributes);
            $.ajax({
                type:"POST",
                url:root_url+"/api/listings/{{Auth::user()->key}}",
                data:grid_event.model.attributes,
                success:function(grid_event,result){
                    grid_event.model.update(result)
                    toastr.success(result.project_information.title +' successfully created!');
                    console.log(result)
                }.bind(null,grid_event)
            })
        }).on("model:edited",function(grid_event){
            console.log(grid_event.model.attributes);
            $.ajax({
                type:"PUT",
                url:root_url+"/api/listings/"+ grid_event.model.attributes.key,
                data:grid_event.model.attributes,
                success:function(result){
                toastr.success(result.project_information.title +' successfully updated!');
                console.log(result)}
        })
        })
        .on("model:deleted",function(grid_event) {
            $.ajax({
                type:"DELETE",
                url:root_url+'/api/listings/'+grid_event.model.attributes.key,
                data:grid_event.model.attributes,
                success:function(result){
                    toastr.success('Successfully deleted!');
                    console.log(result)
                }
                })
        })
    }
});
@endsection
