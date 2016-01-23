@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Permission Roles Edit</h1>
</div>
<div class="panel panel-default">
  	<div class="panel-body">
	{!! Form::open(array('action' => 'PermissionRolesController@postEdit', 'class'=>'','permission'=>"form")) !!}
	  	<div class="form-group {{ $errors->has('permission_id') ? 'has-error' : false }}">
	    	<label class="control-label" for="permission_id">Permission</label>
	    	{!! Form::select('permission_id', $permissions, $p_role->permission_id ,array('id'=>'permission_id','class'=>'form-control')) !!}
	        @foreach($errors->get('permission_id') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
	  	<div class="form-group {{ $errors->has('role_id') ? 'has-error' : false }}">
	    	<label class="control-label" for="role_id">Role</label>
	    	{!! Form::select('role_id', $roles, $p_role->role_id ,array('id'=>'role_id','class'=>'form-control')) !!}
	        @foreach($errors->get('role_id') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
	</div>
		  <div class="panel-footer clearfix">
		  	  <button class="btn btn-primary pull-right" type="submit"> Update </button>
		  </div>
		  <input type="hidden" name="id" value="{{$p_role->id}}">
	  {!! Form::close() !!}
</div>
@stop