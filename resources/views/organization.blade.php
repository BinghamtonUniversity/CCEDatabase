@extends('default')
@section('title',$organization->name)

@section('description')
    @if((config('templates.page.organization.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.organization.alert') !!}
        </div>
    @endif
@endsection

@section('content')
<div class="row">
	<div class="col-sm-6">
		<div class="row"><div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong style="font-size: 150%;">{{$organization->name}}</strong> ({{$organization->type}})<br>
					{{$organization->address1}} | {{$organization->address2}} &nbsp; <a target="_blank" href="http://maps.google.com/maps?q={{$organization->address1}} {{$organization->address2}}">[view map]</a>
				</div>
				<div class="panel-body">{!! nl2br($organization->desc) !!}</div>
			</div>
		</div></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
			        <div class="panel-heading">Current Projects</div>
			        <div class="panel-body">
                        @if(sizeof($listings) > 0)
                            @foreach($listings as $listing)
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{url('/listings/'.$listing->key)}}">{{$listing->title}}</a>
                                    [<?php
                                        if(!check_empty($listing->event_type)) {
                                            switch ($listing->event_type) {
                                                case "ongoing":
                                                    echo "Ongoing";
                                                    break;
                                                case "event":
                                                    echo date('m/d/Y', strtotime($listing->start_date)) . " - " . date('m/d/Y', strtotime($listing->end_date));
                                                    break;
                                                case "annual":
                                                    echo date('m/d', strtotime($listing->start_date)) . " - " . date('m/d', strtotime($listing->end_date));
                                                    break;
                                                default:
                                                    echo "";
                                            }
                                        }else{
                                            if (check_empty($listing->start_date)) {
                                                echo "Ongoing";
                                            } else if ($listing->start_date == $listing->end_date) {
                                                echo date('m/d/Y', strtotime($listing->start_date));
                                            } else {
                                                echo date('m/d/Y', strtotime($listing->start_date))." - ".date('m/d/Y', strtotime($listing->end_date));
                                            }
                                        }
                                    ?>]
                                </div>
                                <div class="col-sm-6">{{$listing->location}}<br>{{$listing->location2}}</div>
                            </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-sm-12">This organization has no current projects in our database</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-heading">Contact Form</div>
                    <div class="panel-body">
                        <div id="form_response" ></div>
                        <div class="contact-form"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Contact Info.
                        <div data-toggle="collapse" href="#collapse-contact-info" class="btn btn-primary btn-xs" style="float:right;">
                            <i class="glyphicon glyphicon-plus"></i> Show
                        </div>
                    </div>
                    <div class="panel-body collapse" id="collapse-contact-info">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Organization Contact</strong>
                                <br><br>
                                <span class="infoLbl">Contact Name</span><br>
                                {{$organization->contact_name}}<em> ({{$organization->contact_title}})</em><br><br>
                                <span class="infoLbl">Email </span><br>
                                <a href="mailto:{{$organization->contact_email}}">{{$organization->contact_email}}</a><br><br>
                                <span class="infoLbl">Phone </span><br>
                                <em>{{$organization->contact_phone}}</em><br><br>
                                @if(!check_empty($organization->contact_address1))
                                    <span class="infoLbl">Mailing Address </span><br>
                                    <em>{{$organization->contact_address1}}</em><br>
                                    <em>{{$organization->contact_address2}}</em><br><br>
                                @endif
                                @if(!check_empty($organization->website))
                                    <span class="infoLbl">Website</span><br>
                                    <a href="{{$organization->website}}" target="_blank">{{$organization->website}}</a><br>
                                @endif
                            </div>
                            @if(!check_empty($organization->contact2_name))
                                <div class="col-sm-6">
                                    <strong>Additional Contact</strong>
                                    <br><br>
                                    <span class="infoLbl">Contact Name</span><br>
                                    {{$organization->contact2_name}}  @if(!check_empty($organization->contact2_title))<em>({{$organization->contact2_title}})</em>@endif<br><br>
                                    @if(!check_empty($organization->contact2_email))
                                        <span class="infoLbl">Email </span><br>
                                        <a href="mailto:{{$organization->contact2_email}}">{{$organization->contact2_email}}</a><br><br>
                                    @endif
                                    @if(!check_empty($organization->contact2_phone))
                                        <span class="infoLbl">Phone </span><br>
                                        <em>{{$organization->contact2_phone}}</em><br><br>
                                    @endif
                                    @if(!check_empty($organization->contact2_address1))
                                        <span class="infoLbl">Mailing Address </span><br>
                                        <em>{{$organization->contact2_address1}}</em><br>
                                        <em>{{$organization->contact2_address2}}</em><br><br>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
		        </div>
            </div>
        </div>
	</div>
</div>
@endsection

@section('scripts')
var contact_form = new gform(contact_form_config, '.contact-form').on('save',function(form_event) {
    if (form_event.form.validate()) {
        toastr.info('Sending Message... Please be patient');
        var contact_form_data = form_event.form.get()
        $.ajax({
            type:"POST",
            url:root_url+"/api/conversations/organization/{{$organization->key}}",
            data:contact_form_data,
            success:function(result){
                toastr.success('Contact Request Sent!');
                form_event.form.trigger('clear');
            }
        })
    }else{
        toastr.error("Please ensure that all required fields have been populated!")
    }
})
@endsection
