@extends('default')

@section('title',"Not Found")

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger" style="text-align:center;align-content:center;margin:auto">
                <h3>Not Found</h3><br>
                <div>
                    <h4>Sorry, the page you are looking for cannot be found</h4>
                    If you think this is in error, please <a href="{{ config('templates.contact_url') }}">contact us.</a>
                </div>
            </div>
        </div>
    </div>
@endsection
