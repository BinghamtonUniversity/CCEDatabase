@extends('default')

@section('title', 'Search Results')

@section('content')
<div class="row">
    {{-- Listings Column --}}
    <div class="col-sm-6">
        <h2>Listings</h2>
        @forelse($listings as $listing)
            <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
                <a href="{{url('/listings/'.$listing->key)}}">
                    {{$listing->title}}
                </a>
            </h4>
            <div style="color:green;">{{$listing->fields}}</div>
            <div>
                <b>Description:</b> 
                {{ Str::limit($listing->desc, 250) }}
            </div>
        @empty
            <div class="alert alert-info" style="margin-top:20px;">
                No listings found matching your search.
            </div>
        @endforelse
    </div>

    {{-- Organizations Column --}}
    <div class="col-sm-6">
        <h2>Organizations</h2>
        @forelse($organizations as $organization)
            <h4 style="margin-top:20px;margin-bottom:0px;text-decoration:underline;">
                <a href="{{url('/organizations/'.$organization->key)}}">
                    {{$organization->name}}
                </a>
            </h4>
            <div style="color:green;">{{$organization->fields}}</div>
            <div>
                <b>Description:</b> 
                {{ Str::limit($organization->desc, 250) }}
            </div>
        @empty
            <div class="alert alert-info" style="margin-top:20px;">
                No organizations found matching your search.
            </div>
        @endforelse
    </div>
</div>

@endsection