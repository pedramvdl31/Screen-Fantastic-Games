@extends($layout)
@section('stylesheets')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
{!! Html::style('/assets/css/inventories/order.css') !!}
@stop
@section('scripts')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/assets/js/inventories/order.js"></script>
@stop

@section('content')
{!! Form::open(array('action' => 'InventoriesController@postOrder', 'class'=>'','id'=>'fileupload','role'=>"form")) !!}
<div class="jumbotron">
  <h1>Inventories Order</h1>
</div>
<div class="panel panel-default">
  <div class="panel-body">
<?php
$count = 0;
?>
    <ul id="sortable">
	@if(isset($all_inventories))
		@foreach($all_inventories as $key => $inv)
		<?php
		$count++;
		?>
			<li class="ui-state-default col-md-3 inv-li" this-inv="{{$inv['id']}}"> <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
				<span class="badge badge-s">{{$count}}</span>
				<input type="hidden" class="order-input-form" name="order-input[{{$inv['id']}}]" this-inv="{{$inv['id']}}" value="{{$inv['order']}}">
				<div class="col-xs-12 col-md-12">
					<a href="#" class="thumbnail">
						<img data-src="holder.js/100%x180" alt="100%x180" src="/assets/images/inventories/perm/{!!$inv['thumbnail_image_src']!!}" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
					</a>
				</div>
			</li>
		@endforeach
	@endif
	</ul>

  </div>

  <div class="panel-footer clearfix">
  	<button type="submit" class="btn btn-primary pull-right">Save</button>
  </div>
</div>
{!! Form::close() !!}
@stop