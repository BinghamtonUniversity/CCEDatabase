@extends('default')

@section('title', 'Service Listings Database')

@section('description')
    @if((config('templates.page.home.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.home.alert') !!}
        </div>
    @endif
@endsection

@section('content')
    {!! config('templates.page.home.body') !!}
@endsection
