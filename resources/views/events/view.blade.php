@extends($layout)
@section('stylesheets')


@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Events Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
        <ul class="list-group">
          <li class="list-group-item" style="color:black;font-size:18px;">{!!$events->title!!}</li>
        </ul>
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>


        <ul class="list-group">
          <li class="list-group-item" style="color:black;">
            {!!$events->decoded_description!!}
          </li>
        </ul>

    </div>


    <div class="form-group {{ $errors->has('date') ? 'has-error' : false }}">
      <label class="control-label" for="date">Event Date</label>
        <ul class="list-group">
          <li class="list-group-item" style="color:black;font-size:18px;">{!!$events->event_date!!}</li>
        </ul>
    </div>


  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('events_index') !!} " class="btn btn-info">Back</a>
    <a href="{!! route('events_edit',$events->id) !!} " class="btn btn-primary pull-right">Edit</a>
  </div>
</div>
@stop