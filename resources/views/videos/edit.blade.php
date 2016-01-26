@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
@stop

@section('content')
<div class="jumbotron">
  <h1>Videos Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'VideosController@postEdit', 'class'=>'','role'=>"form")) !!}
    <input type="hidden" name="video_id" value="{{$videos['id']}}">
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      {!! Form::text('title', $videos['title'], array('class'=>'form-control', 'placeholder'=>'Title')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>
      {!! Form::text('description', $videos['description'], array('class'=>'form-control', 'placeholder'=>'Description')) !!}
        @foreach($errors->get('description') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('url') ? 'has-error' : false }}">
      <label class="control-label" for="url">URL</label>
      {!! Form::text('url', $videos['url'], array('class'=>'form-control', 'placeholder'=>'for exmaple https://www.youtube.com/watch?v=RAwqArI8YQg')) !!}
        @foreach($errors->get('url') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('videos_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Add</button>
  </div>
    {!! Form::close() !!}
</div>
@stop