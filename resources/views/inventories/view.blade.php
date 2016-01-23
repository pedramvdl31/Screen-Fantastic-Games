@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/inventories/view.css') !!}
@stop
@section('scripts')
<script src="/assets/js/inventories/view.js"></script>
@stop

@section('content')
<div class="jumbotron">
	<h1>Inventories View</h1>
</div>
	<div class="panel panel-default">
	  <div class="panel-body">
		<dl class="dl-horizontal in-line" style="font-size:20px">
		  <dt>Title:</dt>
		  <dd><small>{{$inventory['title']}}</small></dd>
			</br>
		  <dt>Description:</dt>
		  <dd><small>{{$inventory['description']}}</small></dd>
		  </br>
		  <dt>Status:</dt>
		  <dd><small>{!!$inventory['status_message']!!}</small></dd>
		  </br>
		  <dt>Created at:</dt>
		  <dd><small>{!!$inventory['created_at_html']!!}</small></dd>
		  </br>
		  <dt>Images:</dt>
		  <dd>
		  	
			<div class="form-group">
					@if(isset($inventory->image_srcs))
						@foreach($inventory->image_srcs as $image_src)
						  <div class="col-sm-6 col-md-4">
						    <div class="thumbnail">
						      	<img class="image-url" style="max-height:140px; max-width:100%; " src="{!! $image_src !!}">
						      <div class="caption clearfix" >
						        	<button type="button" class="btn btn-default btn-sm view-image">View</button>
						      </div>
						    </div>
						  </div>
						@endforeach
					@endif
			</div>

		  </dd>
		</dl>
	  </div>
	  <div class="panel-footer clearfix">
	  	<a href="{!! route('inventory_index') !!} " class="btn btn-info">Back</a>
		<a class="btn btn-primary pull-right" href="{!! route('inventory_edit',$inventory->id) !!}">Edit</a>
	  </div>
	</div>
	{!! View::make('partials.inv_image_modal') !!}
@stop