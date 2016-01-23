@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')

<div class="jumbotron">
  <h1>Reviews (View)</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>Reviews (<a href="{!!route('view_this_item',$review['inventory_id'])!!}">Go to item</a>)</h3></div>
  <div class="panel-body">
	
	<h4>Item Title: <small>{!!$review['item_name']!!}</small></h4>
	<h4>Username: <small>{!!$review['username']!!}</small></h4>
	<h4>Title: <small>{!!$review['title']!!}</small></h4>
	<h4>Description: <small>{!!$review['description']!!}</small></h4>
	<h4>Status: <small>{!!$review['status_message']!!}</small></h4>
	<h4>Created at: <small>{!!$review['created_at_html']!!}</small></h4>
	<hr>
  </div>
  <div class="panel-footer clearfix">
  	
	<a href="{!!route('review_index')!!}" class="btn btn-info btn-sm pull-left">Back</a>
	{!! Form::open(array('action' => 'ReviewsController@postDeleteReview', 'class'=>'','id'=>'fileupload','role'=>"form")) !!}
		<input type="hidden" name="review_id" value="{!!$review['id']!!}">
		<button class="btn-primary pull-right btn-sm" type="submit">Delete</button>
	{!! Form::close() !!}

  </div>
</div>


@stop