@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
	<div class="jumbotron">
		<h1>Welcome</h1>
	</div>

	@if(isset($message))
		<div class="alert alert-success" role="alert">
	      <strong>Well done!</strong> {!! $message !!}
	    </div>
	@endif




@stop