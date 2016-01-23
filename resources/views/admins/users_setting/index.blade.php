@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
<script src="/assets/js/admins/users_setting/index.js"></script>
@stop

@section('content')

<div class="jumbotron">
	<h1>Users Index</h1>
</div>
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
			{!! Form::text('username', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'username','status'=>false)) !!}
			<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
		</div>
		@foreach($errors->get('email') as $message)
		<span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>	
	<div id="searchBy-phone" class="searchByFormGroup form-group hide well well-sm">
		<label class="control-label" for="phone">Phone</label>
		<div class="input-group">
			{!! Form::text('phone', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'phone','status'=>false)) !!}
			<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
		</div>

	</div>	
	<div id="searchBy-email" class="searchByFormGroup form-group {!! $errors->has('email') ? 'has-error' : false !!} well well-sm hide">
		<label class="control-label" for="email">Email</label>
		<div class="input-group">
			{!! Form::text('email', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'(ex: example@example.com)','status'=>false)) !!}
			<a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
		</div>
		@foreach($errors->get('email') as $message)
		<span class='help-block'>{!! $message !!}</span>
		@endforeach
	</div>	
	<div id="searchBy-name" class="searchByFormGroup well well-sm hide">
		<div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
			<label class="control-label" for="firstname">First Name</label>
			{!! Form::text('first_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'First Name')) !!}
			@foreach($errors->get('firstname') as $message)
			<span class='help-block'>{!! $message !!}</span>
			@endforeach
		</div>	
		<div class="form-group {!! $errors->has('last_name') ? 'has-error' : false !!}">
			<label class="control-label" for="last_name">Last Name</label>
			{!! Form::text('last_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Last Name')) !!}
			@foreach($errors->get('last_name') as $message)
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
@stop