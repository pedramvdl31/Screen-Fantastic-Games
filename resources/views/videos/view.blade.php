@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
@stop

@section('content')
<div class="jumbotron">
  <h1>Videos View</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
      <h3>{!!$videos['title']!!}</h3>
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{!!$videos['url']!!}"></iframe>
      </div>

  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('videos_index') !!} " class="btn btn-info">Back</a>
  </div>
</div>
@stop