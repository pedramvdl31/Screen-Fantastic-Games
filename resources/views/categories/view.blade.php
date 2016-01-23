@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
	<h1>Categories View</h1>
</div>
	<div class="panel panel-default">
	  <div class="panel-body">
		<dl class="dl-horizontal in-line" style="font-size:20px">
		  <dt>Title:</dt>
		  <dd><small>{{$category['title']}}</small></dd>
		  <dt>Description:</dt>
		  <dd><small>{{$category['description']}}</small></dd>
		  <dt>Status:</dt>
		  <dd><small>{!!$category['status_message']!!}</small></dd>
		  <dt>Created at:</dt>
		  <dd><small>{!!$category['created_at_html']!!}</small></dd>
		</dl>
	  </div>
	  <div class="panel-footer clearfix">
	  	<a href="{!! route('category_index') !!} " class="btn btn-info">Back</a>
		<a class="btn btn-primary pull-right" href="{!! route('category_edit',$category->id) !!}">Edit</a>
	  </div>
	</div>
@stop