@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/pages/website_pages/general.css') !!}
  {!! Html::style('/assets/css/pages/website_pages/events.css') !!}
@stop
@section('scripts')
@stop

@section('content')

<div class="container" style="margin-top:10px;margin-bottom:30px;">
  <div class="jumbotron my-jumbotron">
    <h1>{{$title}}</h1>
  </div>

      <div class="panel panel-default my-panel-default" style="">
        <div class="my-panel-body panel-body text-left about-text clearfix" style="">
       		{!!$page_content!!}
        </div>
      </div>
 
</div>

@stop