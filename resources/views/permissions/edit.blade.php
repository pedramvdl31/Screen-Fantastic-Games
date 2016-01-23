@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Permissions Edit</h1>
</div>
<div class="panel panel-default">
  	<div class="panel-body">
	{!! Form::open(array('action' => 'PermissionsController@postEdit', 'class'=>'','permission'=>"form")) !!}
		  <div class="form-group">
		    <label for="exampleInputEmail1">Permission Title</label>
		    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="-" value="{{$permissions->permission_title}}">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Permission Slug</label>
		    <input type="text" name="slug" class="form-control" id="exampleInputPassword1" placeholder="-" value="{{$permissions->permission_slug}}">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Permission Description</label>
		    <textarea type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="-" >{{$permissions->permission_description}}</textarea>
		  </div>
	</div>
		  <div class="panel-footer clearfix">
		  	  <button class="btn btn-primary pull-right" type="submit"> Update </button>
		  </div>
		  <input type="hidden" name="id" value="{{$permissions->id}}">
	  {!! Form::close() !!}
</div>
@stop