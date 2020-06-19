@extends('default')

@section('title', 'Google Search Results')

@section('content')
<iframe name="googleSearchFrame" src="{{url('/search/google/iframe')}}?q={{$q}}" frameborder="0" width="100%" height="1300" marginwidth="0" marginheight="0" hspace="0" vspace="0" allowtransparency="true" scrolling="no">
</iframe>

@endsection