@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Videos Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('videos_add')!!}">Videos Add  <i class="glyphicon glyphicon-edit"></i></a></li>
    </ol>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered" style="font-size:18px">
            <thead>
              <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($videos as $tagkey => $tag)
                
                <tr>
                  <th scope="row">{{$tag['id']}}</th>
                  <td>{{$tag['title']}}</td>
                  <td>{{$tag['created_at_html']}}</td>
                  <td>
                    <a href="{!! route('videos_view_it',$tag['id']) !!}">View</a> -
                    <a href="{!! route('videos_edit',$tag['id']) !!}">Edit</a> -
                    <a href="{!! route('videos_remove',$tag['id']) !!}">Delete</a>

                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
</div>
@stop