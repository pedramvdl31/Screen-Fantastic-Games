@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/invoices/user_login.css') !!}
@stop
@section('scripts')
@stop

@section('content')
<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 cols" id="left-col">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title cols-title">Sign In</h3>
					</div>
					<div class="panel-body cols-height">
						@if(isset($incorrect))
							@if($incorrect == 1)
								<div class="alert alert-danger alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  Incorrect Username Or Password!
								</div>
							@endif
						@endif

						{!! Form::open(array('action' => 'InvoicesController@postLoginInvoices','id'=>'reg-form', 'class'=>'','role'=>"form")) !!}
							<div class="form-group">
								<label class="control-label" for="exampleInputEmail1">Username</label>
								<input class="form-control" name="username"
								placeholder="Enter email" type="text">
							</div>
							<div class="form-group">
								<label class="control-label"  for="exampleInputPassword1">Password</label>
								<input class="form-control" name="password" 
								placeholder="Password" type="password">
							</div>
					        <a href="{!! route('registration_view') !!}">Create account</a> or <a href="/password-reset">reset password</a>
							<button type="submit" class="btn btn-success pull-right">Sign-In and Continue</button>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
			<div class="col-md-4 cols" id="right-col">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title cols-title">Continue As Guest</h3>
					</div>
					<div class="panel-body cols-height">
						<span>Not a user yet? No problem! You can just continue as guest.</span>
						<a href="{!!route('invoice_checkout_guest')!!}" class="btn btn-primary btn-block btn-lg cnt-btn" >Continue&nbsp&nbsp&nbsp&nbsp<i class="glyphicon glyphicon-share-alt"></i></a>
					</div>
				</div>
			</div> 	
		</div>
	</div>
</div>
</div>
@stop