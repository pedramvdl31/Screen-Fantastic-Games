@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
	<h1>Access Control List</h1>
  @include('flash::message')
</div>
<div class="container">
  <h2>Permissions</h2>
  <ul class="list-group">
    <a class="list-group-item" href="{!! route('permissions_add') !!}">Add</a>
    <a class="list-group-item">Edit*</a>
    <a class="list-group-item">View*</a>
  </ul>
	<hr>
    <h2>Permission Roles</h2>
  <ul class="list-group">
    <a class="list-group-item" href="">Add</a>
    <a class="list-group-item">Edit*</a>
    <a class="list-group-item">View*</a>
  </ul>
  <hr>
    <h2>Roles</h2>
  <ul class="list-group">
    <a class="list-group-item" href="{!! route('roles_add') !!}">Add</a>
    <a class="list-group-item">Edit*</a>
    <a class="list-group-item">View*</a>
  </ul>
</div>
@stop