@extends('default')

@section('title', 'Service Listings Database')

@section('description')
    @if((config('templates.home_page_alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.home_page_alert') !!}
        </div>
    @endif
@endsection

@section('content')
    {!! config('templates.home_page') !!}
@endsection
