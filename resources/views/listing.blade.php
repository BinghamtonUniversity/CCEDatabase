@extends('default')
@section('title',$listing->title)

@section('description')
    @if((config('templates.page.listing.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.listing.alert') !!}
        </div>
    @endif
@endsection

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
                        <div class="col-sm-8">{{$listing->location}}<br>{{$listing->location2}}</div>
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
                        <div class="col-sm-4">Event Type:</div>
                        <div class="col-sm-8">
                            <?php
                            switch ($listing->event_type){
                                case 'ongoing':
                                    echo "Ongoing";
                                    break;
                                case 'event':
                                    echo "Event";
                                    break;
                                case 'annual':
                                    echo "Annual";
                                    break;
                                default:
                                    echo '';
                            }
                            ?>
                        </div>
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
                        <div class="col-sm-12">{!! nl2br($listing->desc) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="word-break: break-all">
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
                            <strong>Project Contact</strong><br><br>
                            <span class="infoLbl">Contact Name</span><br>
                            {{$listing->contact_name}} <em>({{$listing->contact_title}})</em><br><br>
                            @if(!check_empty($listing->contact_email))
                                <span class="infoLbl">Email </span><br>
                                <a href="mailto:{{$listing->contact_email}}">{{$listing->contact_email}}</a><br><br>
                            @endif
                            @if(!check_empty($listing->contact_phone))
                                <span class="infoLbl">Phone </span><br>
                                {{$listing->contact_phone}}<br><br>
                            @endif
                            @if(!check_empty($listing->contact_address1))
                                <span class="infoLbl">Mailing Address </span><br>
                                {{$listing->contact_address1}}<br>
                                {{$listing->contact_address2}}<br><br>
                            @endif
                            @if(!check_empty($listing->website))
                                <span class="infoLbl">Website</span><br>
                                <a href="{{$listing->website}}" target="_blank">{{$listing->website}}</a><br>
                            @endif
                        </div>
                        @if(!check_empty($listing->name))
                            <div class="col-sm-6">
                                <strong>Additional Contact</strong><br><br>
                                <span class="infoLbl">Contact Name</span><br>
                                {{$listing->contact2_name}} <em>({{$listing->contact2_title}})</em><br><br>
                                @if(!check_empty($listing->contact2_email))
                                    <span class="infoLbl">Email </span><br>
                                    <a href="mailto:{{$listing->contact2_email}}">{{$listing->contact2_email}}</a><br><br>
                                @endif
                                @if(!check_empty($listing->contact2_phone))
                                    <span class="infoLbl">Phone </span><br>
                                    {{$listing->contact2_phone}}<br><br>
                                @endif
                                @if(!check_empty($listing->contact2_address1))
                                    <span class="infoLbl">Mailing Address </span><br>
                                    {{$listing->contact2_address1}}<br>
                                    {{$listing->contact2_address2}}<br><br>
                                @endif
                            </div>
                        @endif
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
                    <iframe style="margin-top: 3px; width: 100%; height: 400px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;q={{$listing->location}} {{$listing->location2}}&amp;source=s_q&amp;hl=en&amp;ie=UTF8&amp;spn=0.002744,0.00456&amp;z=17&amp;output=embed"></iframe>
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
            url:root_url+"/api/conversations/listing/{{$listing->key}}",
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
