@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/pages/website_pages/general.css') !!}
  {!! Html::style('/assets/css/pages/website_pages/events.css') !!}
@stop
@section('scripts')
<script src="/assets/js/pages/website_pages/events.js"></script>
@stop

@section('content')
<style type="text/css">
	.tulasoftware-calendar-iframe{
		height: 877px !important;
	}
</style>

<div class="container" style="margin-top:10px;margin-bottom:30px;">
  <div class="jumbotron my-jumbotron">
    <h1>Calendar</h1>
  </div>

			<div class="panel panel-default my-panel my-panel-default">

			  <div class="panel-body my-panel-body">

				<script type="text/javascript"  async src="https://ubutoday.tulasoftware.com/assets/calendar-widget.js"></script><a class="tulasoftware-calendar-widget" href="https://ubutoday.tulasoftware.com/calendar/embed?c1=1f1f1f&c2=FFCC00&c3=ffffff&c4=949494">Studio Calendar</a>


			  </div>

			</div>

</div>

@stop