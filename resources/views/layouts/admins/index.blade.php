@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Layouts Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('layouts_add')!!}">Layouts Add  <i class="glyphicon glyphicon-edit"></i></a></li>
    </ol>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered" style="font-size:18px">
            <thead>
              <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($layouts as $taxkey => $tax)
                
                <tr>
                  <th scope="row">{{$tax['title']}}</th>
                  <td>{!!$tax['status_message']!!}</td>
                  <td>{{$tax['created_at_html']}}</td>
                  <td>
                    <a href="">View</a> / <a href="{!!route('layouts_edit',$tax['id'])!!}">Edit</a>
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
</div>
@stop