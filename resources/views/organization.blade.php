@extends('default')
@section('title',$organization->name)
@section('content')
<div class="row">
	<div class="col-sm-6">
		<div class="row"><div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong style="font-size: 150%;">{{$organization->name}}</strong> ({{$organization->type}})<br>
					{{$organization->address1}} | {{$organization->address2}} &nbsp; <a style="color: #3299CC; text-decoration: none;" target="_blank" href="http://maps.google.com/maps?q={{$organization->address1}} {{$organization->address2}}">[view map]</a>
				</div>
				<div class="panel-body">{{$organization->desc}}</div>
			</div>
		</div></div>
		
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">			
			        <div class="panel-heading">Current Projects</div>
			        <div class="panel-body">
                        @foreach($listings as $listing)
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{url('/listings/'.$listing->key)}}">{{$listing->title}}</a> 
                                [<?php
                                if (is_null($listing->start_date)) {
                                    echo "Ongoing";
                                } else if ($listing->start_date == $listing->end_date) {
                                    echo date('m/d/Y', strtotime($listing->start_date));
                                } else {
                                    echo date('m/d/Y', strtotime($listing->start_date))." - ".date('m/d/Y', strtotime($listing->end_date));
                                }
                                ?>]
                            </div>
                            <div class="col-sm-6">{{$listing->location}}<br>{{$listing->location2}}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="col-sm-6">
        <div class="row"><div class="col-sm-12"><div class="panel panel-default">
            <div class="panel-heading">
				Contact Info.
			</div>
                    <div class="panel-body" id="toggleinfo">
                    <div class="row">
                    <div class="col-sm-6">
                    <strong>Organization Contact</strong>
                    <br><br>
                    <span class="infoLbl">Contact Name</span><br>
                    {{$organization->contact_name}}<em> ({{$organization->contact_title}})</em><br><br>
                    <span class="infoLbl">Email </span><br>
                    <a href="mailto:{{$organization->contact_email}}">{{$organization->contact_email}}</a><br><br>
                    <span class="infoLbl">Phone </span><br>
                    <em>{{$organization->contact_email}}</em><br><br>
                    <span class="infoLbl">Mailing Address </span><br>
                    <em>{{$organization->contact_address1}}</em><br>
                    <em>{{$organization->contact_address2}}</em><br><br>
                    </div>
                    <div class="col-sm-6">
                    <strong>Additional Contact</strong>
                    <br><br>
                    <span class="infoLbl">Contact Name</span><br>
                    {{$organization->contact2_name}}<em> ({{$organization->contact2_title}})</em><br><br>
                    <span class="infoLbl">Email </span><br>
                    <a href="mailto:{{$organization->contact2_email}}">{{$organization->contact2_email}}</a><br><br>
                    <span class="infoLbl">Phone </span><br>
                    <em>{{$organization->contact2_email}}</em><br><br>
                    <span class="infoLbl">Mailing Address </span><br>
                    <em>{{$organization->contact2_address1}}</em><br>
                    <em>{{$organization->contact2_address2}}</em><br><br>
                    </div>
				</div>
			</div>
		</div></div></div>

		<!-- <div class="row"><div class="col-sm-12"><div class="panel panel-default">			
			<div class="panel-heading">To Contact The Organization, Fill Out This Form</div>
			<div class="panel-body">
			<div id="form_response" ></div>
				<div class="contact-form">
				
				<form id="contact_form" name="contact_me" role="form">
					<div class="form-group">
						<label for="pods">PODS Username (jsmith1) <div class="btn btn-warning btn-xs">BU Only</div></label>
						<input type="text" class="form-control" name="pods" id="pods">
					</div>
					<div class="row"><div class="col-sm-6">
					<input type="hidden" class="form-control" name="org_code_view" value="0C1794">
					
					<div class="form-group">
						<label for="firstname">First Name</label>
						<input type="text" class="form-control" name="firstname">
					</div>
					</div><div class="col-sm-6">
					<div class="form-group">
						<label for="lastname">Last Name</label>
						<input type="text" class="form-control" name="lastname">
					</div>
					</div></div>
					<div class="row"><div class="col-sm-6">
					<div class="form-group">
						<label for="email">Email Address</label>
						<input type="text" class="form-control" name="email">
					</div>
					</div><div class="col-sm-6">
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="text" class="form-control" name="phone">
					</div>
					</div></div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea class="form-control" name="message"></textarea>
					</div>
					<div class="form-group" style="display:none;">
						<label for="critical">Critical</label>
						<input type="text" class="form-control" name="critical">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
</div>
			</div>
		</div></div></div> -->
	</div>
</div>
@endsection