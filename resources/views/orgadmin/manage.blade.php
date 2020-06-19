@extends('default')

@section('title',"Manage: ".Auth::user()->name)
@section('description','This page provides a portal for organizations and service groups to manage their organization page and project listings from one convenient location.')

@section('content')
<div>
    <a href="{{url('/manage/logout')}}" class="btn btn-danger pull-right">Logout</a>
</div>

<div id="org-admin-update-org-btn" class="btn btn-primary">Update My Organization</div>
<div class="alert alert-info" style="margin-top:15px;">
    <h3>Instructions:</h3>
    Use the <div class="btn btn-success btn-xs">New</div> button below to create a new listing.  <br>
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
                    $.ajax({
                        type: "POST",
                        url: root_url+"/api/organizations/"+form_data.key,
                        data: form_event.form.get(),
                        success: function(response) {
                            toastr.success('Organization Info Updated!');
                            form_event.form.trigger('close')
                        },
                        error: function(response) {
                            toastr.error('There was an error!');
                        }
                    });
                }).on('cancel',function(form_event) {
                    form_event.form.trigger('close');
                })
            }
        });  
    }); 
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
            console.log(id);
            ajax.put('/api/modules/'+id+'/permissions/',grid_event.model.attributes,function(data) {
                grid_event.model.update(data)
            },function(data) {
                grid_event.model.undo();
            });
        }).on("model:deleted",function(grid_event) {
            ajax.delete('/api/modules/'+id+'/permissions/'+grid_event.model.attributes.id,{},function(data) {},function(data) {
                grid_event.model.undo();
            });
        })
    }
});
@endsection