@extends('default')

@section('title', 'Search Results')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <h2>Listings</h2>
        @foreach($listings as $listing)
            <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
                <a href="{{url('/listings/'.$listing->key)}}">
                    {{$listing->title}}
                </a>
            </h4>
            <div style="color:green;">{{$listing->fields}}</div>
            <div>
                <b>Description:</b> 
                {{substr($listing->desc,0,250)}}
            </div>
        @endforeach
    </div>
	<div class="col-sm-6">
	    <h2>Organizations</h2>
        @foreach($organizations as $organization)
            <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
                <a href="{{url('/organizations/'.$organization->key)}}">
                    {{$organization->name}}
                </a>
            </h4>
            <div style="color:green;">{{$organization->fields}}</div>
            <div>
                <b>Description:</b> 
                {{substr($organization->desc,0,250)}}
            </div>
        @endforeach
    </div>
</div>
@endsection