@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')

	<div class="jumbotron">
		<h1>Permission Roles Add</h1>
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


	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Information</h3>
	  </div>
	  <div class="panel-body">
    		{!! Form::open(array('action' => 'PermissionRolesController@postAdd', 'class'=>'','role'=>"form")) !!}
		  	<div class="form-group {{ $errors->has('permission_id') ? 'has-error' : false }}">
		    	<label class="control-label" for="permission_id">Permission</label>
		    	{!! Form::select('permission_id', $permissions, null ,array('id'=>'permission_id','class'=>'form-control')) !!}
		        @foreach($errors->get('permission_id') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('role_id') ? 'has-error' : false }}">
		    	<label class="control-label" for="role_id">Role</label>
		    	{!! Form::select('role_id', $roles, null ,array('id'=>'role_id','class'=>'form-control')) !!}
		        @foreach($errors->get('role_id') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
				  <button class="btn btn-primary pull-right">Save</button>
			{!! Form::close() !!}
	  </div>
	</div>







	    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" >
      {{--*/ $num = 1 /*--}}
      @foreach($roles_array as $keyrole => $role)
      <li class="{{$num==1?'active':''}}">
        <a href="#{{$role}}" role="tab" data-toggle="tab">
          {{$role}}
        </a>
      </li>
      {{--*/ $num++ /*--}}
      @endforeach
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <spc style="margin:10px;"></spc>
      {{--*/ $num_2 = 1 /*--}}
      @foreach($output as $output_s => $value)
      <div class="tab-pane fade {{$num_2 == 1?'active in':''}}" id="{{$output_s}}">
        <table class="table table-bordered">
          <tbody>
            @foreach($value as $kslugs => $slugs)
            <tr>
              <th scope="row">{{$slugs}}</th>
              <td>
                <a href="{!! route('permission_roles_edit',$kslugs) !!}">Edit</a>
                  |
                <a href="{!! route('permission_roles_delete',$kslugs) !!}" style="color:#d9534f">Delete</a>
              </td>
            </tr>

            @endforeach
          </tbody>
        </table>
      </div>
      {{--*/ $num_2++ /*--}}
      @endforeach
    </div>




@stop