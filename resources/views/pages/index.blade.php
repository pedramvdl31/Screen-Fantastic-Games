@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Pages Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('pages_add')!!}">Pages Add  <i class="glyphicon glyphicon-edit"></i></a></li>
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
              @foreach ($pages as $pagekey => $page)
                
                <tr>
                  <th scope="row">{{$page['title']}}</th>
                  <td>{!!$page['status_message']!!}</td>
                  <td>{{$page['created_at_html']}}</td>
                  <td>
                    @if($page['id'] != 1)
                    <a href="">View</a> / <a href="{!!route('pages_edit',$page['id'])!!}">Edit / <a href="{!!route('pages_remove',$page['id'])!!}">Delete</a>
                    @endif
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
</div>
@stop