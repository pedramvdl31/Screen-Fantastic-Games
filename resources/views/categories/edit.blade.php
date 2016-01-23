@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/categories/edit.css') !!}
@stop
@section('scripts')
<script src="/assets/js/categories/edit.js"></script>
@stop

@section('content')
<div class="jumbotron">
	<h1>Categories Edit</h1>
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
    		{!! Form::open(array('action' => 'CategoriesController@postEdit', 'class'=>'','role'=>"form")) !!}
			  	<div class="form-group {{ $errors->has('category-title') ? 'has-error' : false }}">
			    	<label class="control-label" for="category-title">Category title</label>
			    	{!! Form::text('category-title', $category->title, array('class'=>'form-control', 'placeholder'=>'Category Title')) !!}
			        @foreach($errors->get('category-title') as $message)
			            <span class='help-block'>{{ $message }}</span>
			        @endforeach
			  	</div>
			  	<div class="form-group {{ $errors->has('category-description') ? 'has-error' : false }}">
			    	<label class="control-label" for="category-description">Category Description</label>
			    	{!! Form::textarea('category-description', $category->description, array('class'=>'form-control', 'placeholder'=>'Category Description')) !!}
			        @foreach($errors->get('category-description') as $message)
			            <span class='help-block'>{{ $message }}</span>
			        @endforeach
			  	</div>
				<div class="form-group {{ $errors->has('status') ? 'has-error' : false }}">
			    	<label class="control-label" for="status">Status</label>
			    	{!! Form::select('cats', $select_data, $category->status ,array('id'=>'cats','class'=>'form-control custom-dropdown__select')) !!}
			  	</div>
			  	<input type="hidden" name="cat_id" value="{{$category->id}}">

	  </div>

	   <div class="panel-footer clearfix">

			 <button class="btn btn-primary pull-right">Update</button>
	   </div>
	</div>
	{!! Form::close() !!}
@stop