@extends('default')
@section('title',$listing->title)
@section('description','')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <h2 style="float: left; margin-bottom: 0px;">{{$listing->title}}</h2>
        <h2 style="text-align: right; margin-bottom: 0px;">{{$organization->name}}</h2>
        <span style="font-size: 13px; padding: 0px 0px 0px 10px;">
            @if($listing->type == "short") Short-Term Project
            @else Long-Term Project @endif
        </span>
    </div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="col-sm-6">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Date and Location {{$listing->dates}}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">Days of Work:</div>
                        <div class="col-sm-8">{{$listing->days}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">Time(s) of Day: </div>
                        <div class="col-sm-8">{{$listing->time}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">Address: </div>
                        <div class="col-sm-8">{{$listing->location}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Project Details</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">Organization:</div>
                        <div class="col-sm-8">
                            <a href="{{url('/organizations/'.$organization->key)}}">{{$organization->name}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">Project Category:</div>
                        <div class="col-sm-8">{{$listing->category}} ({{parse_yesno($listing->paid,'Paid','Unpaid')}})</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">Weekly Hours:</div>
                        <div class="col-sm-8">{{$listing->hours}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">People Needed: </div>
                        <div class="col-sm-8">{{$listing->num_participants}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">Seeking: </div>
                        <div class="col-sm-8">{{$listing->participants}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">Project Description</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">{{$listing->desc}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Requirements</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">Training Required:</div>
                            <div class="col-sm-8">{{parse_yesno($listing->reqs_training)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Immunization Proof:</div>
                            <div class="col-sm-8">{{parse_yesno($listing->reqs_immune)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Application Needed:</div>
                            <div class="col-sm-8">{{parse_yesno($listing->reqs_application)}}</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Other Requirements:</div>
                            <div class="col-sm-8">{{$listing->reqs_desc}}</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact Info.
                    <!-- <div id="togglebtn" class="btn btn-primary btn-xs" style="float:right;"><i class="glyphicon glyphicon-plus"></i> Show</div> -->
                </div>
                <div class="panel-body" id="toggleinfo">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Project Contact</strong><br><br>
                            <span class="infoLbl">Contact Name</span><br>
                            {{$listing->contact_name}} <em>({{$listing->contact_title}})</em><br><br>
                            <span class="infoLbl">Email </span><br>
                            <a href="mailto:{{$listing->contact_email}}">{{$listing->contact_email}}</a><br><br>
                        </div>
                        <div class="col-sm-6">
                            <strong>Additional Contact</strong><br><br>
                            <span class="infoLbl">Contact Name</span><br>
                            {{$listing->contact2_name}} <em>({{$listing->contact2_title}})</em><br><br>
                            <span class="infoLbl">Email </span><br>
                            <a href="mailto:{{$listing->contact2_email}}">{{$listing->contact2_email}}</a><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Project Location (On Bus Route)</div>
                <div class="panel-body" style="padding:0px;">
                    <iframe style="margin-top: 3px; width: 100%; height: 400px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;q={{{$listing->location}}}&amp;source=s_q&amp;hl=en&amp;ie=UTF8&amp;spn=0.002744,0.00456&amp;z=17&amp;output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Old Contact Form -- BROKEN! -->
    <!-- <div class="row"><div class="col-sm-12"><div class="panel panel-default">
        <div class="panel-heading">To Contact The Project, Fill Out This Form</div>
        <div class="panel-body">
                    <div id="form_response" ></div>
            <div class="contact-form">

            <form id="contact_form" name="contact_me" role="form">
                <div class="form-group">
                    <label for="pods">PODS Username (jsmith1) <div class="btn btn-warning btn-xs">BU Only</div></label>
                    <input type="text" class="form-control" name="pods" id="pods">
                </div>
                <div class="row"><div class="col-sm-6">
                                    <input type="hidden" class="form-control" name="listing_key" value="994">
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
            </form></div>
        </div>
    </div></div></div> -->
    <!--<div class="row"><div class="col-sm-12"><div class="panel panel-default">
        <div class="panel-body">
            <div style="font-size: 13px; color: #0000FF; text-align: center;">
            <div class="panel-heading"><span style="font-size: 100%;">This project was posted by<br /><strong style="font-size: 120%;">CCE Youth Initiatives</strong><br /><br /></div>
            Visit the <a style="color: #0000FF;" href="vieworg.php?oid=MEMxNzk0">CCE Youth Initiatives Organization Page</a>
            to find out more information about this organization and other projects they have posted with us.</span></div>
        </div>
    </div></div></div>-->
</div>
@endsection
