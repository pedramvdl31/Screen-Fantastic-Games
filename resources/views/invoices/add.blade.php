@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
<!-- The main application script -->
<script type="text/javascript" src="/packages/priceformat/priceformat.min.js"></script>
<script type="text/javascript" src="/assets/js/invoices/add.js"></script>
@stop

@section('content')
<div class="jumbotron">
	<h1>Invoices Add</h1>
</div>
   {!! Form::open(array('action' => 'InvoicesController@postAdd', 'class'=>'','role'=>"form")) !!}

<div class="row col-md-12 col-sm-12 col-xs-12">
	<div class="col-md-3 col-sm-3 col-xs-12">
		<div class="panel panel-info">
			<div class="panel-body">
				<ul id="deliveryStepy" class="nav nav-pills nav-stacked">
					<li class="active " role="presentation"><a href="#findUser"><span class="badge">1</span>&nbspSelect Customer</a></li>
					<li class="customerInfo" role="presentation"><a href="#customerInfo"><span class="badge">2</span> Customer Info</a></li>
					<li class="menuSelection" role="presentation"><a href="#invoiceInfo"><span class="badge">3</span> Invoice Info {!! (Session::get('menu_error') == true) ? '<span class="label label-danger pull-right">1 error</span>' : '' !!}</a></li>
					<li role="presentation"><a href="#confirmation"><span class="badge">6</span> Confirmation</a></li>
				</ul>
			</div>
		</div>

	</div>
	<div class="col-md-9 col-sm-9 col-xs-12">


		<!-- ====================== -->
		<!-- ********STEP 1******** -->
		<!-- ====================== -->
		<div id="findUser" class="steps panel panel-info form-horizontal">
			<div class="panel-heading">
				<h4>Select User</i></h4>
			</div>
			<div class="panel-body">
				<div id="customerMembers" class="customerListDiv">
					<div class="form-group">
						<label class="control-label" for="id">Find By:</label>
						{!! Form::select('search',$search_by ,'username', ['id'=>'searchBy','class'=>'form-control','status'=>false]) !!}
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div id="searchBy-id" class="searchByFormGroup form-group {!! $errors->has('id') ? 'has-error' : false !!} well well-sm hide">
						<label class="control-label" for="id">User Id</label>
						<div class="input-group">
							{!! Form::text('id', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'user id','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('id') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach


					</div>	
					<div id="searchBy-username" class="searchByFormGroup form-group {!! $errors->has('username') ? 'has-error' : false !!} well well-sm">
						<label class="control-label" for="username">Username</label>
						<div class="input-group">
							{!! Form::text('usernamenull', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'username','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('usernamenull') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div id="searchBy-phone" class="searchByFormGroup form-group hide well well-sm">
						<label class="control-label" for="phone">Phone</label>
						<div class="input-group">
							{!! Form::text('phonenull', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'phone number','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
					</div>	
					<div id="searchBy-email" class="searchByFormGroup form-group {!! $errors->has('email') ? 'has-error' : false !!} well well-sm hide">
						<label class="control-label" for="email">Email</label>
						<div class="input-group">
							{!! Form::text('emailnull', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'(ex: example@example.com)','status'=>false)) !!}
							<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
						</div>
						@foreach($errors->get('emailnull') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div id="searchBy-name" class="searchByFormGroup well well-sm hide">
						<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
							<label class="control-label" for="firstname">First Name</label>
							{!! Form::text('first_namenull', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'First Name')) !!}
							@foreach($errors->get('firstnamenull') as $message)
							<span class='help-block'>{!! $message !!}</span>
							@endforeach
						</div>	
						<div class="form-group {!! $errors->has('last_name') ? 'has-error' : false !!}">
							<label class="control-label" for="last_name">Last Name</label>
							{!! Form::text('last_namenull', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Last Name')) !!}
							@foreach($errors->get('last_namenull') as $message)
							<span class='help-block'>{!! $message !!}</span>
							@endforeach
						</div>	
						<div class="form-group">
							<button type="button" class="searchByButton btn btn-info"><i class="glyphicon glyphicon-search"></i> Search</button>
						</div>			
					</div>
					<table id="userSearchTable" class="table table-hover hide" style="margin-bottom:20px;">
					<thead>
							<tr>
								<th>Id</th>
								<th>Username</th>
								<th>First</th>
								<th>Last</th>
								<th>Email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>	
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="next btn btn-primary pull-right" step="1">Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>

		</div>
		<!-- ====================== -->
		<!-- ********STEP 1######## -->
		<!-- ====================== -->





		<!-- ====================== -->
		<!-- ********STEP 2******** -->
		<!-- ====================== -->		
		<div id="customerInfo" class="steps panel panel-info hide">
			<div class="panel-heading">
				<h4>Customer Information</i></h4>
			</div>
			<div class="panel-body">
				<div id="customerGuests" class="customerListDiv">
					<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
						<label class="control-label" for="firstname">First Name</label>
						{!! Form::text('firstname', null, array('id'=>'firstName','class'=>'form-control', 'placeholder'=>'First Name')) !!}
						@foreach($errors->get('firstname') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div class="form-group {!! $errors->has('lastname') ? 'has-error' : false !!}">
						<label class="control-label" for="lastname">Last Name</label>
						{!! Form::text('lastname', null, array('id'=>'lastName','class'=>'form-control', 'placeholder'=>'Last Name')) !!}
						@foreach($errors->get('lastname') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('naver_username') ? 'has-error' : false !!}">
						<label class="control-label" for="naver_username">Naver Username</label>
						{!! Form::text('naver_username', null, array('id'=>'naver-username','class'=>'form-control', 'placeholder'=>'Naver Username')) !!}
						@foreach($errors->get('naver_username') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>
					<div class="form-group {!! $errors->has('email') ? 'has-error' : false !!}">
						<label class="control-label" for="email">Email</label>
						{!! Form::text('email', null, array('id'=>'email','class'=>'form-control', 'placeholder'=>'(ex: example@example.com)','status'=>false)) !!}
						@foreach($errors->get('email') as $message)
						<span class='help-block'>{!! $message !!}</span>
						@endforeach
					</div>	
					<div class="form-group {!! $errors->has('phone') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('phone', 'Phone Number', array('class' => 'control-label')) !!}
						{!! Form::text('phone', null, array('id'=>'phone','class'=>'form-control form-phone', 'placeholder'=>'eg ### ### ####')) !!}
						@foreach($errors->get('phone') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 	
					<div class="form-group {!! $errors->has('street') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('street', 'Street Address', array('class' => 'control-label')) !!}
						{!! Form::text('street', null, array('id'=>'street','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Street Address')) !!}
						@foreach($errors->get('street') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>
					<div class="form-group {!! $errors->has('unit') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_unit', 'Unit', array('class' => 'control-label')) !!}
						{!! Form::text('unit', null, array('id'=>'unit','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Unit')) !!}
						@foreach($errors->get('unit') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('zipcode') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('zipcode', 'Zipcode / Postal Code', array('class' => 'control-label')) !!}
						{!! Form::text('zipcode', null, array('id'=>'zipcode','class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'Zipcode')) !!}
						@foreach($errors->get('zipcode') as $message)
						<span class='help-block hide'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>
					<div class="form-group {!! $errors->has('city') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('city', 'City', array('class' => 'control-label')) !!}
						{!! Form::text('city', null, array('id'=>'city','class'=>'form-control', 'not_empty'=>'true', 'placeholder'=>'City','data-provide'=>'typeahead', 'autocomplete'=>'off')) !!}
						@foreach($errors->get('city') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>	
					<div class="form-group {!! $errors->has('state') ? 'has-error has-feedback' : false !!}">
						<label class="control-label" for="state">State <small><em>(If applicable)</em></small></label>
						{!! Form::text('state', null, array('id'=>'state','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'State')) !!}
						@foreach($errors->get('state') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>	
					<div class="form-group {!! $errors->has('country') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('country', 'Country', array('class' => 'control-label')) !!}
						{!! Form::select('country', $country_code, 'US', array('id'=>'country','class'=>'form-control','not_empty'=>'true')) !!}
						@foreach($errors->get('country') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>	
				</div>


			</div>

			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" class="next btn btn-primary pull-right" step="2">Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
		<!-- ====================== -->		
		<!-- ########STEP 2######## -->
		<!-- ====================== -->





		<!-- ====================== -->
		<!-- ********STEP 3******** -->
		<!-- ====================== -->		
		<div id="invoiceInfo" class="steps panel panel-info hide">
			<div class="panel-heading">
				<h4>Invoice Information</i></h4>
			</div>
			<div class="panel-body">
				<div id="customerGuests" class="customerListDiv">

					<div class="form-group {!! $errors->has('pretax') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_pretax', 'Pretax', array('class' => 'control-label')) !!}
						{!! Form::text('pretax', null, array('id'=>'pretax','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Pretax')) !!}
						@foreach($errors->get('pretax') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('tax') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_tax', 'Tax', array('class' => 'control-label')) !!}
						{!! Form::text('tax', null, array('id'=>'tax','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Tax')) !!}
						@foreach($errors->get('tax') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('aftertax') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_aftertax', 'Aftertax', array('class' => 'control-label')) !!}
						{!! Form::text('aftertax', null, array('id'=>'aftertax','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Aftertax')) !!}
						@foreach($errors->get('aftertax') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('quantity') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_quantity', 'Quantity', array('class' => 'control-label')) !!}
						{!! Form::text('quantity', null, array('id'=>'quantity','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Quantity')) !!}
						@foreach($errors->get('quantity') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('payment_id') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('_payment_id', 'Payment_id', array('class' => 'control-label')) !!}
						{!! Form::text('payment_id', null, array('id'=>'payment_id','class'=>'form-control','not_empty'=>'true', 'placeholder'=>'Payment_id')) !!}
						@foreach($errors->get('payment_id') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div> 
					<div class="form-group {!! $errors->has('payment_type') ? 'has-error has-feedback' : false !!}">
						{!! Form::label('payment_type', 'Payment_type', array('class' => 'control-label')) !!}
						{!! Form::select('payment_type', $payment_select, null, array('id'=>'payment_type','class'=>'form-control','not_empty'=>'true')) !!}
						@foreach($errors->get('payment_type') as $message)
						<span class='help-block'>{!! $message !!}</span>
						<span class="glyphicon glyphicon-ok form-control-feedback"></span>
						@endforeach
						@if(count($errors) == 0)
						<span class='help-block hide'></span>
						<span class="glyphicon glyphicon-ok form-control-feedback hide"></span>
						@endif
					</div>	


				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="button" class="previous btn btn-default" step="2"><i class="glyphicon glyphicon-chevron-left"></i> Previous</button>
				<button type="button" class="next btn btn-primary pull-right" step="2">Next <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
		<!-- ====================== -->		
		<!-- ########STEP 3######## -->
		<!-- ====================== -->		


<!-- ====================== -->
		<!-- ********STEP 3******** -->
		<!-- ====================== -->		
		<div id="confirmation" class="steps panel panel-info hide">
			<div class="panel-heading">
				<h4>Invoice Information</i></h4>
			</div>
			<div class="panel-body">
				<div id="" class="conf">

				</div>
			</div>
			<div class="panel-footer clearfix">
				<button type="submit" class="btn btn-primary pull-right">Submit Invoice</button>
			</div>
		</div>
		<!-- ====================== -->		
		<!-- ########STEP 3######## -->
		<!-- ====================== -->		



	</div>
</div>

@if(session()->has('data'))
	<input type="hidden" id="customer_id_input" name="customer_id" value="{{session()->has('data')}}">
@else
	<input type="hidden" id="customer_id_input" name="customer_id" value="0">
@endif
	

{!! Form::close() !!}
	
@stop