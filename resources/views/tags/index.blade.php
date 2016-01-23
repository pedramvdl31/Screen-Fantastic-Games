@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Tags Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('tags_add')!!}">Tags Add  <i class="glyphicon glyphicon-edit"></i></a></li>
    </ol>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered" style="font-size:18px">
            <thead>
              <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($tags as $tagkey => $tag)
                
                <tr>
                  <th scope="row">{{$tag['title']}}</th>
                  <td>{{$tag['created_at_html']}}</td>
                  <td>
                    <a href="">View</a> / 
                    <a href="{!! route('tags_edit',$tag['id']) !!}">Edit</a>
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
</div>
@stop