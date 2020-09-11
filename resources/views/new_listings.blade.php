@extends('default')

@section('title', 'New Listings')

@section('description')
    @if((config('templates.page.newlistings.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.newlistings.alert') !!}
        </div>
    @endif
    View the 30 most recently posted listings, ordered from newest
    ({{date('m/d/y', strtotime($listings[0]->timestamp))}})
    to oldest
    ({{date('m/d/y', strtotime($listings[count($listings)-1]->timestamp))}})
@endsection

@section('content')
    @foreach ($listings as $listing)
    <div class="row"><div class="col-sm-12"><div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-right badge">
            Posted: {{date('m/d/y', strtotime($listing->timestamp))}}        </div>
            <b><a href="{{url('/listings/'.$listing->key)}}">
            {{$listing->title}}        </a></b>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">Organization:</div>
                <div class="col-sm-8">
                    <a href="{{url('/organizations/'.$listing->organization['key'])}}">{{$listing->organization['name']}}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Dates:</div>
                <div class="col-sm-8">
                <?php
                    if($listing->event_type === 'ongoing' || is_null($listing->end_date)){
                        echo "Ongoing";
                    }
                    else if($listing->event_type === 'annual'){
                        echo "Annual - ". date('l F jS, Y', strtotime($listing->start_date))." through ".date('l F jS, Y', strtotime($listing->end_date)); ;
                    }
                    else{
                        echo date('l F jS, Y', strtotime($listing->start_date))." through ".date('l F jS, Y', strtotime($listing->end_date));
                    }
                ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">Project Category:</div>
                <div class="col-sm-8">{{$listing->category}} ({{parse_yesno($listing->paid,'Paid','Unpaid')}})</div>
            </div>
            <div class="row">
                <div class="col-sm-4">Seeking: </div>
                <div class="col-sm-8">{{$listing->participants}}</div>
            </div>
            <div class="row">
                <div class="col-sm-12">Project Description</div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                {!! substr($listing->desc,0,250)!!}
                    <span class="label label-info">
                        <a style="color:white;" href="{{url('listings'.'/'.$listing->key)}}">Click here for more info!</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
