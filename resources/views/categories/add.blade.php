@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
	<h1>Categories Add</h1>
</div>
	@if(isset($message_feedback))
		<div class="alert alert-success" role="alert">
	      <strong>Well done!</strong> {!! $message_feedback !!}
	    </div>
	@endif
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Information</h3>
	  </div>
	  <div class="panel-body">
    		{!! Form::open(array('action' => 'CategoriesController@postAdd', 'class'=>'','role'=>"form")) !!}
		  	<div class="form-group {{ $errors->has('category-title') ? 'has-error' : false }}">
		    	<label class="control-label" for="category-title">Category title</label>
		    	{!! Form::text('category-title', null, array('class'=>'form-control', 'placeholder'=>'Category Title')) !!}
		        @foreach($errors->get('category-title') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('category-description') ? 'has-error' : false }}">
		    	<label class="control-label" for="category-description">Category Description</label>
		    	{!! Form::textarea('category-description', null, array('class'=>'form-control', 'placeholder'=>'Category Description')) !!}
		        @foreach($errors->get('category-description') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
				 
			
	  </div>
	  <div class="panel-footer">
	  	<a href="{!! route('category_index') !!} " class="btn btn-info">Back</a>
	  	 <button class="btn btn-primary pull-right">Add</button>
	  </div>
	</div>
	{!! Form::close() !!}
@stop