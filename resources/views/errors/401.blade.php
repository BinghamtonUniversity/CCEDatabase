@extends('default')

@section('title',"Not Authorized")

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger" style="text-align:center;align-content:center;margin:auto">
                <h3>Not Authorized</h3><br>
                <div>
                    <h4>You are not authorized to visit this page</h4>
                    If you think this is in error, please <a href="{{config('templates.contact_url')}}">contact us.</a>
                </div>
            </div>
        </div>
    </div>
@endsection
