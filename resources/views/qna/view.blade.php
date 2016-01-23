@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
{!! Form::open(array('action' => 'QnAController@postView', 'class'=>'','id'=>'fileupload','role'=>"form")) !!}
<div class="jumbotron">
  <h1>Questions And Answers (View)</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>Q&A (<a href="{!!route('view_this_item',$qnas['inventory_id'])!!}">Go to item</a>)</h3></div>
  <div class="panel-body">
	
	<h4>Item Title: <small>{!!$qnas['item_name']!!}</small></h4>
	<h4>Username: <small>{!!$qnas['username']!!}</small></h4>
	<h4>Title: <small>{!!$qnas['title']!!}</small></h4>
	<h4>Description: <small>{!!$qnas['description']!!}</small></h4>
	<h4>Status: <small>{!!$qnas['status_message']!!}</small></h4>
	<h4>Created at: <small>{!!$qnas['created_at_html']!!}</small></h4>
	<hr>
	<h3>Reply to User</h3>
    <div class="form-group">
        <textarea  class="form-control" name="description" id="q_and_a_description"  placeholder="Description" style="resize: vertical;"></textarea>
    </div>
    <button class="btn btn-primary pull-right">Post Reply</button>
  </div>
</div>
<input type="hidden" name="qna_id" value="{!!$qna_id!!}">
<input type="hidden" name="inventory_id" value="{!!$qnas['inventory_id']!!}">
{!! Form::close() !!}
@stop