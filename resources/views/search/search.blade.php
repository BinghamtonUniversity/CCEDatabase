@extends('default')

@section('title', 'Search')

@section('description')
    @if((config('templates.page.search.alert'))!=='')
        <div class="alert alert-danger">
            {!! config('templates.page.search.alert') !!}
        </div>
    @endif
@endsection

@section('content')
<div class="panelpanel-default">
    <div class="panel-body">
        <div class="search-form"></div>
    </div>
</div>
@endsection

@section('scripts')
var search_form = new gform(search_form,'.search-form').on('save',function(data){
    if (data.form.validate()) {
        var form_data = data.form.get();
        var req_data;
        var req_url
        if(!form_data.is_advanced){
            req_data = {
                q:form_data.keyword
            }
            req_url = "/search/google";
        } else {
            req_data = {
                fields:form_data.advanced_search.interest_areas,
                event_type:form_data.advanced_search.event_type
            }
            if(form_data.advanced_search.category!==undefined){
                req_data.category = form_data.advanced_search.category
            }
            req_url = "/search/results";

        }
        window.location.href = root_url + req_url+ '/?'+$.param(req_data)
    }
})

@endsection
