<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title')</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<!-- google fonts -->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800|Lora:400,500,600,700">
<link rel="stylesheet" href="{{url('/assets/css/ccedb.css')}}" type="text/css" />
<link href="{{url('/assets/css/toastr.min.css')}}" rel="stylesheet">
<link href="{{url('/assets/css/font-awesome.min.css')}}" rel="stylesheet">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="margin-top:119px;">

<!-- New Stuff -->
<nav class="navbar navbar-fixed-top navbar-default" style="background-color:#004333;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" style="width:100%;">
      <a class="navbar-brand" href="https://www.binghamton.edu/cce/" style="height:60px;padding:7.5px 4.5px;color:white;font-weight: 400;font-size: 1.3rem;">
        <img src="https://www.binghamton.edu/assets/img/logo/binghamton-university.png" alt="Binghamton University Logo" style="width:351px;">
        <span class="hidden-xs" style="font-size: 22px;border-left: 1px solid #fff;margin-left: 10px;padding: 5px 0px 5px 10px;vertical-align: middle;">
            Center for Civic Engagement
        </span>
      </a>
      <div class="hidden-xs" style="float:right;text-align:right;margin-top:5px;">
				<a class="btn btn-xs btn-primary" href="{{ config('templates.contact_url') }}">Contact CCE</a>
				<a class="btn btn-xs btn-primary" href="{{route('manage_page')}}">Manage Account</a>
		  </div>
    </div>
  </div><!-- /.container-fluid -->
</nav>
<!-- End New Stuff -->

<nav class="navbar navbar-fixed-top navbar-default" role="navigation" style="margin-top:60px;border:0px;">
  <div class="container-fluid" style="background-color:rgba(0,90,67,1);">
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
          {!! config('templates.menu') !!}
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid" style="background-color:white" style="position:fixed;top:119px;">
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
            {!! config('templates.footer') !!}
        </div>
    </div>
</div>
<script src="{{url('/assets/js/vendor/jquery.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/bootstrap.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/lodash.min.js')}}"></script>
<script>_.findWhere = _.find; _.where = _.filter;_.pluck = _.map;_.contains = _.includes;</script>
<script src="{{url('/assets/js/vendor/hogan.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/toastr.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/gform_bootstrap.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/GrapheneDataGrid.min.js')}}"></script>
<script src="{{url('/assets/js/vendor/moment.js')}}"></script>
<script src="{{url('/assets/js/vendor/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript">
var root_url = "{{url('/')}}";
</script>
<script type="text/javascript" src="{{url('/assets/js/ccedb.js')}}"></script>
<script>
@yield('scripts')
</script>
<!-- Begin Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-1861349-1', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
</body>
</html>
