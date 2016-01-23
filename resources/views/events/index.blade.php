@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Events Index</h1>
    <ol class="breadcrumb">
      <li class="active">Overview</li>
      <li><a href="{!!route('events_add')!!}">Events Add  <i class="glyphicon glyphicon-edit"></i></a></li>
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
                <th>Event Date</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($all_events as $ackey => $cat)
                <tr>
                  <th scope="row">{{$cat['id']}}</th>
                  <td>{{$cat['title']}}</td>
                  <td>{{$cat['event_date']}}</td>
                  <td>{!!$cat['status_message']!!}</td>
                  <td>{{$cat['created_at_html']}}</td>
                  <td>
                    <a href="{!! route('events_view',$cat->id) !!}">View</a>&nbsp|
                    &nbsp<a href="{!! route('events_edit',$cat->id) !!}">Edit
                    |&nbsp<a href="{!! route('events_remove',$cat->id) !!}">Delete</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
  </div>

</div>
@stop