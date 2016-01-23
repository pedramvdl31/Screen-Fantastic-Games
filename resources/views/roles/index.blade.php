@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Roles Index</h1>
</div>
<div class="panel panel-default">
  <div class="panel-body">
<table class="table table-bordered" style="font-size:18px">
      <thead>
        <tr>
          <th>#</th>
          <th>Roles</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      	@foreach ($roles as $role)
        <tr>
          <th scope="row">{{$role->id}}</th>
          <td>{{$role->role_title}}</td>
          <td>
            <a href="{!! route('roles_edit',$role->id) !!}">Edit</a>
              |
            <a href="{!! route('roles_delete',$role->id) !!}" style="color:#d9534f">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="panel-footer clearfix">
  	  <a class="btn btn-primary pull-right" href="{!! route('permissions_index') !!}"> Next Step </a>
  	  <a class="btn btn-primary pull-left" href="{!! route('roles_add') !!}"> Add New Role </a>
  </div>
</div>

@stop