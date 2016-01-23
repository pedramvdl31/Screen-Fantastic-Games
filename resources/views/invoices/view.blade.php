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

		  <dt>User Id:</dt>
		  <dd><small>{{$invoices['user_id']}}</small></dd>
			</br>
		  <dt>Naver Username:</dt>
		  <dd><small>{{$invoices['naver_username']}}</small></dd>
		  </br>
		  <dt>First Name:</dt>
		  <dd><small>{!!$invoices['firstname']!!}</small></dd>
		  </br>
		  <dt>Last Name:</dt>
		  <dd><small>{!!$invoices['lastname']!!}</small></dd>
		  </br>
		  <dt>Email:</dt>
		  <dd><small>{!!$invoices['email']!!}</small></dd>
		  </br>
		  <dt>Phone:</dt>
		  <dd><small>{!!$invoices['phone']!!}</small></dd>
		  </br>
		  <dt>Country:</dt>
		  <dd><small>{!!$invoices['country']!!}</small></dd>
		  </br>
		  <dt>City:</dt>
		  <dd><small>{!!$invoices['city']!!}</small></dd>
		  </br>
		  <dt>Street:</dt>
		  <dd><small>{!!$invoices['street']!!}</small></dd>
		  </br>
		  <dt>First Name:</dt>
		  <dd><small>{!!$invoices['firstname']!!}</small></dd>
		  </br>
		  <dt>Zipcode:</dt>
		  <dd><small>{!!$invoices['zipcode']!!}</small></dd>
		  </br>
		  <dt>Pretax:</dt>
		  <dd><small>{!!$invoices['pretax']!!}</small></dd>
		  </br>
		  <dt>Tax:</dt>
		  <dd><small>{!!$invoices['tax']!!}</small></dd>
		  </br>
		  <dt>AfterTax:</dt>
		  <dd><small>{!!$invoices['aftertax']!!}</small></dd>
		  </br>
		  <dt>Payment Id:</dt>
		  <dd><small>{!!$invoices['payment_id']!!}</small></dd>
		  </br>
		  <dt>Payment Merchant:</dt>
		  <dd><small>{!!$invoices['payment_merchant_html']!!}</small></dd>
		  </br>
		  <dt>Created at:</dt>
		  <dd><small>{!!$invoices['created_at_html']!!}</small></dd>
		</dl>
	  </div>
	  <div class="panel-footer clearfix">
		<a class="btn btn-primary pull-right" href="{!! route('invoice_edit',$invoices->id) !!}">Edit</a>
	  </div>
	</div>
	{!! View::make('partials.inv_image_modal') !!}
@stop