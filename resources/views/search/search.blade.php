@extends('default')

@section('title', 'Search')

@section('content')
<div class="panelpanel-default">
    <div class="panel-body">
{{--        <div id="search_form" ></div>--}}
        <div class="search-form"></div>
    </div>

{{--<h2>General Search</h2>--}}
{{--<form role="search" name="searchListingsQuick" action="{{url('/search/google')}}" method="get">--}}
{{--  <div class="row"><div class="col-sm-6">--}}
{{--  <div class="form-group">--}}
{{--    <input type="text" class="form-control" placeholder="Project or Org Name / Description" name="q" id="quickKeywords">--}}
{{--  </div>--}}
{{--  </div></div>--}}
{{--  <div class="row"><div class="col-sm-12">--}}
{{--  <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--  </div></div>--}}
{{--</form>--}}
{{--<br>--}}
{{--<h2>Advanced Search</h2>--}}

{{--<form name="searchListings" id="searchListingsAdvanced" action="{{url('/search/results')}}" method="get">--}}
{{--<div class="row">--}}
{{--	<div class="col-sm-12">--}}
{{--		<div class="form-group">--}}
{{--			<label>Project Category</label>--}}
{{--			<select class="form-control" name="category">--}}
{{--				<option value="">--</option>--}}
{{--				<option value="Internship">Internship</option>--}}
{{--				<option value="Research">Research</option>--}}
{{--				<option value="Service">Service</option>--}}
{{--				<option value="Group Project">Group</option>--}}
{{--			</select>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--	<div class="col-sm-12"><label>Interest Areas</label></div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--	<div class="col-sm-12">--}}
{{--<div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Abuse/Violence Counseling and/or Prevention">Abuse/Violence Counseling and/or Prevention</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Animal Care">Animal Care</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Arts/Humanities/Culture">Arts/Humanities/Culture</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Business/Management/Entrepreneurship">Business/Management/Entrepreneurship</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Crisis Intervention">Crisis Intervention</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Disability Support">Disability Support</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Education">Education</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Elder Services">Elder Services</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Environmental">Environmental</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Food and Nutrition">Food and Nutrition</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Health">Health</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Homeless and/or Housing">Homeless and/or Housing</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Human Rights">Human Rights</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Human Services">Human Services</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Immigration Services/Refugee Resettlement">Immigration Services/Refugee Resettlement</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Interpretation/Translation Services">Interpretation/Translation Services</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Journalism/Media">Journalism/Media</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Politics/Policy/Government">Politics/Policy/Government</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Social Work/Counseling/Therapy">Social Work/Counseling/Therapy</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Sports and Recreation">Sports and Recreation</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Student Groups">Student Groups</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Technology">Technology</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Volunteerism">Volunteerism</label> </div></div><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Womens Issues">Womens Issues</label> </div></div></div><div class="row"><div class="col-sm-4"> <div class="checkbox">  <label><input type="checkbox" name="fields[ ]" value="Youth">Youth</label> </div></div></div>--}}
{{--	</div>--}}
{{--</div>--}}

{{--<input type="submit" name="search" value="Search Listings &amp; Orgs" class="btn btn-primary">--}}
{{--</form>--}}
</div>
@endsection

@section('scripts')
var search_form = new gform(search_form,'.search-form').on('save',function(data){
// console.log(form_data.form.get())
                    var form_data = data.form.get();
                    var req_data;
                    var req_url
                    if(!form_data.is_advanced){
                        req_data = {
                            q:form_data.keyword
                        }
                        req_url = "/search/google";
                    }
                    else{
                        req_data = {
                            fields:form_data.advanced_search.interest_areas,
                            event_type:form_data.advanced_search.event_type
                        }
                        if(form_data.advanced_search.category!==undefined){
                            req_data.category = form_data.advanced_search.category
                        }
                        req_url = "/search/results";

                    }
{{--                    console.log(root_url+req_url)--}}
{{--debugger--}}
                    window.location.href = root_url + req_url+ '/?'+$.param(req_data)

{{--                    $.ajax({--}}
{{--                        type:"GET",--}}
{{--                        url:root_url+req_url,--}}
{{--                        data:req_data,--}}
{{--                        success:function(result){--}}
{{--                            debugger--}}
{{--                            console.log(result)--}}

{{--                            }--}}
{{--                        })--}}
})

@endsection
