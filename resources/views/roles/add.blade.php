@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')

	<div class="jumbotron">
		<h1>Roles Add</h1>
		<a href="" id="url" class="hide" target="_blank"></a>
		<div class="alert alert-warning delivery-area-alert hide clearfix">
		</div>
	</div>
	@if(isset($message_feedback))
		<div class="alert alert-success" role="alert">
	      <strong>Well done!</strong> {!! $message_feedback !!}
	    </div>
	@endif
	<div class="alert alert-danger {{isset($validator)?'':'hide'}}" role="alert">
	  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	  <span class="sr-only">Error:</span>
	  	Validation Failed
	</div>
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Information</h3>
	  </div>
	  <div class="panel-body">
    		{!! Form::open(array('action' => 'RolesController@postAdd', 'class'=>'','role'=>"form")) !!}
		  	<div class="form-group {{ $errors->has('role-title') ? 'has-error' : false }}">
		    	<label class="control-label" for="role-title">Role title</label>
		    	{!! Form::text('role-title', null, array('class'=>'form-control', 'placeholder'=>'role title')) !!}
		        @foreach($errors->get('role-title') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('role-slug') ? 'has-error' : false }}">
		    	<label class="control-label" for="role-slug">Role Slug</label>
		    	{!! Form::text('role-slug', null, array('class'=>'form-control', 'placeholder'=>'role slug')) !!}
		        @foreach($errors->get('role-slug') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
				  <button class="btn btn-primary pull-right">Add</button>
			{!! Form::close() !!}
	  </div>
	</div>
@stop