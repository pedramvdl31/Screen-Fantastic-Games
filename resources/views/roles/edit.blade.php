@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="panel panel-default">
  <div class="panel-body">
	{!! Form::open(array('action' => 'RolesController@postEdit', 'class'=>'','role'=>"form")) !!}
		  <div class="form-group">
		    <label for="exampleInputEmail1">Role Title</label>
		    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="-" value="{{$roles->role_title}}">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Role Slug</label>
		    <input type="text" name="slug" class="form-control" id="exampleInputPassword1" placeholder="-" value="{{$roles->role_slug}}">
		  </div>
		  </div>
		  <div class="panel-footer clearfix">
		  	  <button class="btn btn-primary pull-right" type="submit"> Update </button>
		  </div>
		  <input type="hidden" name="role_id" value="{{$roles->id}}">
	  {!! Form::close() !!}
</div>
@stop