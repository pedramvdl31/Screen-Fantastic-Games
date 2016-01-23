@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/pages/website_pages/general.css') !!}
  {!! Html::style('/assets/css/pages/website_pages/events.css') !!}
@stop
@section('scripts')
<script src="/assets/js/pages/website_pages/events.js"></script>
@stop

@section('content')

<div class="container" style="margin-top:10px;margin-bottom:30px;">
  <div class="jumbotron my-jumbotron">
    <h1>Our Events</h1>
  </div>

  	@if(isset($events))
  		@foreach($events as $event)
			<div class="panel panel-default my-panel my-panel-default">
			  <div class="panel-heading clearfix my-panel-heading">
			    <h3 class="panel-title pull-left">{{$event->title}}</h3>
			    {!!$event->date_formated_label!!}
			  </div>
			  <div class="panel-body my-panel-body">
			    {!!$event->decoded_description!!}
			  </div>
			  <div class="panel-footer my-panel-footer clearfix">
			    <a class="pull-right btn btn-warning btn-sm interested_btn">interested&nbsp<i class="glyphicon glyphicon-heart interested-icon"></i></a>
			  </div>
			</div>
  		@endforeach
  	@endif
 
</div>

@stop