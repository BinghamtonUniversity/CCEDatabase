<!DOCTYPE html>
<html>
<head>
<title>@yield('title')</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//cdn.datatables.net/autofill/1.2.0/css/dataTables.autoFill.css"/>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{url('/styles/styles.css')}}" type="text/css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="margin-top:120px;">

<!-- New Stuff -->
<nav class="navbar navbar-fixed-top navbar-default" style="background-color:#004333;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" style="width:100%;">
      <a class="navbar-brand" href="/cce" style="height:60px; padding:7.5px 4.5px;color:white;">
        <img src="https://www.binghamton.edu/assets/img/logo/binghamton-university.png" style="width:351px;">
        <span class="hidden-xs" style="font-size: 22px;border-left: 1px solid #fff;margin-left: 10px;padding: 5px 0px 5px 10px;vertical-align: middle;">
          CCE Service Listings
        </span>
      </a>
      <div class="hidden-xs" style="float: right; text-align: right;">
				<a class="navLnk" href="/cce/about/index.html">Contact Us | </a>
				<a class="navLnk" href="manage.php">Manage Service Listings</a>
		  </div>
    </div>    
  </div><!-- /.container-fluid -->
</nav>
<!-- End New Stuff -->

<nav class="navbar navbar-fixed-top navbar-default" role="navigation" style="margin-top:60px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
  <li><a href="{{url('/')}}">Home</a></li>
  <li><a href="{{url('/listings/new')}}"><span style="font-size: 14px;" class="label label-primary">New Listings!</span></a></li>
	<li><a href="{{url('/organizations')}}">Organizations</a></li>
	<li><a href="{{url('/search')}}">Search</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid" style="background-color:white">
    <div class="row" style="text-align:center;">
        <h2 class="headline">@yield('title')</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <p style="margin-left: 0px; font-size: 108%;">@yield('description')</p>
        </div>
    </div>
    <div>
        @yield('content')
    </div>
    <div class="row">
        <div id="footer">
            &copy; 2020 Binghamton University Center for Civic Engagement | 
            <a href="/cce/about/index.html" style="color:white;">Contact the Office</a>
        </div>
    </div>
</div>
<!-- Begin Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-1861349-1', 'auto');  // Replace with your property ID.
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
</body>
</html>
