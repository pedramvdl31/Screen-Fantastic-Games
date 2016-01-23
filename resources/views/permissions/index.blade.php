@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')


<div class="jumbotron">
  <h1>Permissions Index</h1>
</div>

<div class="panel panel-default">
  <div class="panel-body">

  
  <div class="table-responsive">
<table class="table table-bordered" style="font-size:18px">
      <thead>
        <tr>
          <th>#</th>
          <th>Permission Title</th>
          <th>Permission Slug</th>
          <th>Role Title</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($permissions as $permission)
        <tr>
          <th scope="row">{{$permission->id}}</th>
          <td>{{$permission->permission_title}}</td>
          <td>{{$permission->permission_slug}}</td>
          <td>
          @if(isset($permission->role_list))
            @foreach($permission->role_list as $role_list)
              <span class="badge" style="font-size:16px">{{ $role_list }}</span>
            @endforeach
          @endif
          </td>
          <td>
            <a href="{!! route('permissions_edit',$permission->id) !!}">Edit</a>
            |
            <a href="{!! route('permissions_delete',$permission->id) !!}" style="color:#d9534f">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  </div>
  <div class="panel-footer clearfix">
  	  <a class="btn btn-primary pull-right" href="{!! route('permission_roles_index') !!}"> Next Step </a>
  	  <a class="btn btn-primary pull-left" href="{!! route('permissions_add') !!}"> Add New Role </a>
      <a href="/permissions/auto-update" class="btn btn-primary pull-left">Auto Update</a>
  </div>
</div>

@stop