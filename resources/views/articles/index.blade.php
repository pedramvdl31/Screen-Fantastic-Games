@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Articles Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('articles_add')!!}">Articles Add  <i class="glyphicon glyphicon-edit"></i></a></li>
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
              @foreach ($articles as $tagkey => $tag)
                
                <tr>
                  <th scope="row">{{$tag['id']}}</th>
                  <td>{{$tag['title']}}</td>
                  <td>{{$tag['created_at_html']}}</td>
                  <td>
                    <a href="{!! route('articles_edit',$tag['id']) !!}">Edit</a> -
                    <a href="{!! route('articles_remove',$tag['id']) !!}">Delete</a>
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
</div>
@stop