@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
	<h1>Users Edit</h1>
</div>
{!! Form::open(array('action' => 'AdminsController@postUsersEdit', 'class'=>'','role'=>"form")) !!}
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit</h3>
  </div>
  <div class="panel-body">
		
	  	<div class="form-group {{ $errors->has('username') ? 'has-error' : false }}">
	    	<label class="control-label" for="username">Username</label>
	    	{!! Form::text('username', $users->username, array('class'=>'form-control', 'placeholder'=>'username')) !!}
	        @foreach($errors->get('username') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
	  	<div class="form-group {{ $errors->has('category-title') ? 'has-error' : false }}">
	    	<label class="control-label" for="firstname">First Name</label>
	    	{!! Form::text('fname', $users->firstname, array('class'=>'form-control', 'placeholder'=>'firstname')) !!}
	        @foreach($errors->get('firstname') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
	  	<div class="form-group {{ $errors->has('lastname') ? 'has-error' : false }}">
	    	<label class="control-label" for="lastname">Last Name</label>
	    	{!! Form::text('lname', $users->lastname, array('class'=>'form-control', 'placeholder'=>'lastname')) !!}
	        @foreach($errors->get('lastname') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
	  	<div class="form-group {{ $errors->has('email') ? 'has-error' : false }}">
	    	<label class="control-label" for="email">Email</label>
	    	{!! Form::text('email', $users->email, array('class'=>'form-control', 'placeholder'=>'email')) !!}
	        @foreach($errors->get('email') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
  		<div class="form-group {{ $errors->has('role_id') ? 'has-error' : false }}">
	    	<label class="control-label" for="role_id">Role</label>
	    	{!! Form::select('role_id', $roles, $user_role_id ,array('id'=>'role_id','class'=>'form-control')) !!}
	        @foreach($errors->get('role_id') as $message)
	            <span class='help-block'>{{ $message }}</span>
	        @endforeach
	  	</div>
  </div>
  <div class="panel-footer clearfix">
		<button class="btn btn-primary pull-right">Update</button>
		<input type="hidden" name="id" value="{{$users->id}}">
  </div>
  {!! Form::close() !!}
</div>
@stop