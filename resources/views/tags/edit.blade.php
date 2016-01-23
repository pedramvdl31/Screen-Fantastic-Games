@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
  <script type="text/javascript" src="/assets/js/tags/edit.js"></script>
@stop

@section('content')
<div class="jumbotron">
  <h1>Tags Edit</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'TagsController@postEdit', 'class'=>'','role'=>"form")) !!}
    
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      {!! Form::text('title', $tags['title'], array('class'=>'form-control', 'placeholder'=>'Title')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>
      {!! Form::text('description', $tags['description'], array('class'=>'form-control', 'placeholder'=>'Description')) !!}
        @foreach($errors->get('description') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('tags_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Edit</button>
    <a class="btn btn-danger pull-right" id="delete-page" this-href="{{$tags->id}}">Delete</a>

  </div>

  <input type="hidden" name="id" value="{{$tags['id']}}">
    {!! Form::close() !!}
</div>
@stop