@extends('default')

@section('title', 'Organizations')

@section('description')
    @if((config('templates.organizations_page_alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.organizations_page_alert') !!}
        </div>
    @endif
    This page shows all of the organizations who are listed in our database in ascending 
    alphabetical order. You can click on the links below to view each organization page. 
    Each page contains contact details, project listings, and other information regarding 
    the organization.
@endsection

@section('content')
    @foreach ($letters as $letter)    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">			
                <div class="panel-heading">{{$letter}}</div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($organizations as $organization)
                            @if ($organization->name[0] === $letter || $organization->name[0] === strtolower($letter))
                                <div class="col-sm-4">
                                    <a href="{{url('/organizations/'.$organization->key)}}">{{$organization->name}}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection