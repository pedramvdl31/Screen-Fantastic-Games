@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')

<div class="jumbotron">
	<h1>Category</h1>
</div>
<div class="container">
  <ul class="list-group">
    <a class="list-group-item" href="/admins/categories/add">Add</a>
    <a class="list-group-item" href="/admins/categories/edit">Edit</a>
    <a class="list-group-item" href="/admins/categories/view">View*</a>
  </ul>
</div>
@stop