@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
	<script type="text/javascript" src="{!! asset('js/app.min.js') !!}"></script>
@stop

@section('content')

	<div class="jumbotron">
		<h1>Permissions Add</h1>
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

	{!! Form::open(array('action' => 'PermissionsController@postAdd', 'class'=>'','role'=>"form")) !!}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Information</h3>
		</div>

		<div class="panel-body">

			<div class="form-group {{ $errors->has('permission-slug') ? 'has-error' : false }}">
				<label class="control-label" for="permission-slug">Permission Slug</label>
				{!! Form::select('permission-slug', $all_routes, null ,array('id'=>'permission-slug','class'=>'form-control')) !!}
				@foreach($errors->get('permission-slug') as $message)
				<span class='help-block'>{{ $message }}</span>
				@endforeach
			</div>		  	
			<div class="form-group {{ $errors->has('permission-title') ? 'has-error' : false }}">
				<label class="control-label" for="permission-title">Permission title</label>
				{!! Form::text('permission-title', null, array('class'=>'form-control', 'placeholder'=>'Permission Title')) !!}
				@foreach($errors->get('permission-title') as $message)
				<span class='help-block'>{{ $message }}</span>
				@endforeach
			</div>
			<div class="form-group {{ $errors->has('permission-description') ? 'has-error' : false }}">
				<label class="control-label" for="permission-description">Permission Description</label>
				{!! Form::textarea('permission-description', null, array('class'=>'form-control', 'placeholder'=>'Permission Description')) !!}
				@foreach($errors->get('permission-description') as $message)
				<span class='help-block'>{{ $message }}</span>
				@endforeach
			</div>
		</div>
		<div class="panel-body">

		</div>
		<div class="panel-footer clearfix">
			<a class="btn btn-default pull-left" href="{!! route('acl_view') !!}">Back</a>
			<button class="btn btn-primary pull-right">Add</button>
			{!! Form::close() !!}

			<a href="/permissions/auto-update" class="btn btn-primary pull-right">Auto Update</a>
		</div>
	</div>

@stop