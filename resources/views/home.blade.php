@extends('default')

@section('title', 'Service Listings Database')

@section('description')
    Welcome to the Center for Civic Engagement (CCE) Service Listings database. 
    The CCE cultivates partnerships that strengthen communities and develop 
    active and engaged citizens.
@endsection

@section('content')
<div class="row">
	<div class="col-sm-5">
		<div class="row">
			<div class="col-sm-12">
				<div><a href="http://www.binghamton.edu/cce/service-listings-best-practices.pdf">View our Service Listings Best Practices Guide for Students</a></div>
				<div class="alert alert-info">No car? No problem. <a target="_blank" href="http://arcg.is/2dH9peV">Find transportation to your service opportunity. </a></div>

				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Students</h3> 
						<a class="cyanLnk" href="search.php" style="font-size: 100%; font-weight: bold;">Search</a> for service opportunities that interest you.
						<hr>
						<h3>Faculty &amp; Staff</h3> 
						<a class="cyanLnk" href="search.php" style="font-size: 100%; font-weight: bold;">Search</a> for community connections and projects that you can incorporate into your service-learning course curriculum.
						<hr>
						<h3>Community Leaders</h3> 
						<a class="cyanLnk" href="addorg.php" style="font-size: 100%; font-weight: bold;">List</a> your organization's projects to recruit volunteers, interns, or partners.
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-7">
		<img src="img_bin/home_collage.jpg" style="width:100%;">
	</div>
</div>
@endsection